<?php

class VerificarInpiService
{  
    public static function download()
    {
        try 
        {
            $url_base = 'https://revistas.inpi.gov.br/rpi/';
            $html = file_get_contents($url_base);

            if (!$html) {
                throw new Exception('Sistema fora do ar: '.print_r($html));
            }

            $dom = new DOMDocument();
            libxml_use_internal_errors(true); // evita warnings de HTML malformado
            $dom->loadHTML($html);
            libxml_clear_errors();

            // Cria XPath e busca o <tr class="warning">
            $xpath = new DOMXPath($dom);
            $trList = $xpath->query('//tr[contains(@class, "warning")]');

            if ($trList->length === 0) {
                throw new Exception("Nenhum <tr class='warning'> encontrado.");
            }

            // Pega o primeiro <td> dentro do <tr>
            $tdList = $trList[0]->getElementsByTagName('td');

            if ($tdList->length === 0) {
                throw new Exception("Nenhum <td> dentro do <tr class='warning'>.");
            }

            $numero_rpi = trim($tdList[0]->textContent);

            if(file_exists("app/output/RM{$numero_rpi}/RM{$numero_rpi}.xml")) {
                return ['numero_rpi' => $numero_rpi, 'xml_path' => "app/output/RM{$numero_rpi}/RM{$numero_rpi}.xml"];
            }

            // 4. Baixar o arquivo ZIP
            $zip_url = "https://revistas.inpi.gov.br/txt/RM{$numero_rpi}.zip";
            $zip_path = "app/output/RM{$numero_rpi}.zip";

            file_put_contents($zip_path, fopen($zip_url, 'r'));

            if (!file_exists($zip_path) OR filesize($zip_path) == 0) {
                throw new Exception('Arquivo .zip não encontrado.');
            }

            // 6. Descompactar o ZIP
            $zip = new ZipArchive;
            $extract_path = "app/output/RM{$numero_rpi}";
            if ($zip->open($zip_path) !== TRUE) {
                throw new Exception('Arquivo .zip não encontrado.');               
            } 
            $zip->extractTo($extract_path);
            $zip->close();

            // 7. Acessar o XML extraído
            $xml_file = "$extract_path/RM{$numero_rpi}.xml";
            if (file_exists($xml_file)) {
                return ['numero_rpi' => $numero_rpi, 'xml_path' => $xml_file];
            }

            return "Arquivo XML não encontrado.";

        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function processar()
    {
        try 
        {
            TTransaction::open('db_monitor');
            $xml_file = self::download();
            if(!is_array($xml_file))
                throw new Exception('Erro no Download');

            $xml = simplexml_load_file($xml_file['xml_path']);

            $data = (string) $xml['data'];

            $aTbProcesso = TbProcesso::getIndexedArray('num_protocolo', 'id');

            // Itera pelos processos
            foreach ($xml->processo as $processo) {
                //echo($processo)."<br>";
                $numero = (string) $processo['numero'];

                if (isset($aTbProcesso[$numero])) 
                {
                    $texto_evento = '';
                    // TEXTO DESPACHO
                    if (isset($processo->despachos)) {
                        foreach ($processo->despachos->despacho as $d) {
                            $codigo = (string) $d['codigo'];
                            $nome   = (string) $d['nome'];
                            $texto_evento .= "<p><strong>Despacho ({$codigo}):</strong> {$nome}</p>";
                        }
                    }

                    // TEXTO TITULAR
                    if (isset($processo->titulares)) {
                        foreach ($processo->titulares->titular as $titular) {
                            $nome_razao = (string) $titular['nome-razao-social'];
                            $pais       = (string) $titular['pais'];
                            $uf         = (string) $titular['uf'];
                            $texto_evento .= "<p><strong>Titular:</strong> {$nome_razao} ({$uf} - {$pais})</p>";
                        }
                    }
                    
                    $oTbProcesso                         = new TbProcesso($aTbProcesso[$numero]);
                    $newTbProcessoEvento                 = new TbProcessoEvento();
                    $newTbProcessoEvento->tb_processo_id = $oTbProcesso->id;
                    $newTbProcessoEvento->num_revista    = $xml_file['numero_rpi'];
                    $newTbProcessoEvento->data_evento    = TDate::date2us($data);
                    $newTbProcessoEvento->texto_evento   = $texto_evento;
                    $newTbProcessoEvento->system_unit_id = $oTbProcesso->system_unit_id;
                    $newTbProcessoEvento->store();

                    $oTbProcesso->data_ultimo_evento     = TDate::date2us($data);
                    $oTbProcesso->store();
                }
            }
            
            TTransaction::close();
        } catch (Exception $e) {
            TTransaction::rollback();

            new TMessage('error', $e->getMessage());

            
            // NOTIFICAR O ADMINISTRADOR SOBRE ALGUM ERRO
            TSession::setValue('userid', 1);
            $user_id = 1;
            $icon = 'fas fa-check-circle';
            SystemNotification::register( $user_id, 'Erro na Busca INPI', $e->getMessage(), new TAction(['TbProcessoList', 'onShow'], []), 'Verificar', $icon);
        }
    }
}
