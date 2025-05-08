<?php

class DownloadXmlService
{
    
    public static function obterUltimaRevista()
    {
        try
        {
            // URL da página a ser raspada
            $url = 'https://revistas.inpi.gov.br/rpi/';
            
            // Obter o conteúdo da página
            $html = file_get_contents($url);
            
            // Criar uma nova instância do DOMDocument
            $dom = new DOMDocument;
            
            // Carregar o HTML na instância do DOMDocument
            libxml_use_internal_errors(true); // Evitar warnings ao carregar HTML
            $dom->loadHTML($html);
            libxml_clear_errors();
            
            // Criar uma nova instância do DOMXPath
            $xpath = new DOMXPath($dom);
            
            // Definir a expressão XPath para selecionar o primeiro 'td' da 'tr' com classe 'warning'
            $query = "//tr[contains(@class, 'warning')]/td[1]";
            $entries = $xpath->query($query);
            
            // Verificar se algum resultado foi encontrado
            if ($entries->length > 0) {
                // Obter o valor do primeiro 'td'
                $value = $entries->item(0)->nodeValue;
                
                return $value;
                
            } else {
                throw new Exception('Erro ao buscar última revista!');
            }
            
        } catch (\Throwable $e) {
            throw $e;
        }
    }
    
    public static function downloadFile($revista = NULL)
    {
        try 
        {
            TTransaction::open('db_monitor');
            
            if(is_null($revista)) {
                $ultima_revista = self::obterUltimaRevista();
            } else {
                $ultima_revista = $revista;
            }
            
            $oTbParam = TbParam::first();
            
            if( (int) $oTbParam->ultima_revista >= (int) $ultima_revista AND is_null($revista)) {
                TTransaction::close();
                echo("Não há novas revistas!");
                return;
            } else {
                
            }
            
            $url = "https://revistas.inpi.gov.br/txt/RM{$revista}.zip";
            
            // Diretório onde o arquivo ZIP será salvo
            $path = "app/output/RM{$revista}.zip";
        
            // Baixar o arquivo ZIP usando cURL
            $ch = curl_init($url);
            $fp = fopen($path, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        
            if (curl_exec($ch) === false) {
                echo 'Erro no cURL: ' . curl_error($ch);
                $path = NULL;
            } else {
                echo "Arquivo baixado com sucesso: $path";
            }
        
            curl_close($ch);
            fclose($fp);
            
            if(!is_null($path))
                self::extractZip($path, $revista);
            
            TTransaction::close();
            
        } catch (Exception $e) {
            
            TTransaction::rollback();
            echo($e->getMessage());
        }
    }
    
    public static function extractZip($path, $revista)
    {
        try
        {
            // Diretório onde o conteúdo do ZIP será extraído
            $extractToDir = "app/output/xml";
            
            // Verificar se o arquivo ZIP foi baixado com sucesso
            if (file_exists($path)) {
                // Criar instância do ZipArchive
                $zip = new ZipArchive;
            
                // Abrir o arquivo ZIP
                if ($zip->open($path) === TRUE) {
                    // Criar o diretório de extração, se não existir
                    if (!file_exists($extractToDir)) {
                        mkdir($extractToDir, 0777, true);
                    }
            
                    // Extrair o conteúdo do ZIP para o diretório especificado
                    $zip->extractTo($extractToDir);
                    $zip->close();
            
                    echo "Arquivo extraído com sucesso para: $extractToDir\n";
                    self::getDados("app/output/xml/RM{$revista}.xml");
    
                } else {
                    throw new Exception("Falha ao abrir o arquivo ZIP.");
                }
            } else {
                throw new Exception("Falha ao baixar o arquivo ZIP.");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    
    public static function getDados($path)
    {
        try 
        {
            $string = file_get_contents($path);
            $xml = simplexml_load_string($string);
            
            $aTbProcesso = TbProcesso::where('status', '=', 'A')->load();
            
            foreach ($aTbProcesso as $oTbProcesso) 
            {
                // Número do processo que você quer encontrar (por exemplo, do banco de dados)
                $processoNumero = $oTbProcesso->protocolo;
                
                // Usar XPath para encontrar o processo com o número especificado
                $result = $xml->xpath("//processo[@numero='$processoNumero']");
                
                // Verificar se o processo foi encontrado
                if ($result) {
                    
                    $oNewTbProcessoMovimentacao = new TbProcessoMovimentacao();
                    
                    $processo = $result[0];
                    
                    // Acessar dados do processo encontrado
                    $processoDataDeposito = (string) $processo['data-deposito'];
                    $despachoCodigo = (string) $processo->despachos->despacho['codigo'];
                    $despachoNome = (string) $processo->despachos->despacho['nome'];
                    $titularNome = (string) $processo->titulares->titular['nome-razao-social'];
                    $titularPais = (string) $processo->titulares->titular['pais'];
                    $titularUf = (string) $processo->titulares->titular['uf'];
                    $marcaApresentacao = (string) $processo->marca['apresentacao'];
                    $marcaNatureza = (string) $processo->marca['natureza'];
                    $marcaNome = (string) $processo->marca->nome;
                    $classeViennaCodigo = (string) $processo->{'classes-vienna'}->{'classe-vienna'}['codigo'];
                    $classeViennaEdicao = (string) $processo->{'classes-vienna'}->{'classe-vienna'}['edicao'];
                    $classeNiceCodigo = (string) $processo->{'lista-classe-nice'}->{'classe-nice'}['codigo'];
                    $classeNiceEspecificacao = (string) $processo->{'lista-classe-nice'}->{'classe-nice'}->especificacao;
                    $classeNiceStatus = (string) $processo->{'lista-classe-nice'}->{'classe-nice'}->status;
                    $procurador = (string) $processo->procurador;
                
                    echo "Processo Número: $processoNumero\n";
                    echo "Data de Depósito: $processoDataDeposito\n";
                    echo "Despacho Código: $despachoCodigo\n";
                    echo "Despacho Nome: $despachoNome\n";
                    echo "Titular Nome: $titularNome\n";
                    echo "Titular País: $titularPais\n";
                    echo "Titular UF: $titularUf\n";
                    echo "Marca Apresentação: $marcaApresentacao\n";
                    echo "Marca Natureza: $marcaNatureza\n";
                    echo "Marca Nome: $marcaNome\n";
                    echo "Classe Vienna Código: $classeViennaCodigo\n";
                    echo "Classe Vienna Edição: $classeViennaEdicao\n";
                    echo "Classe Nice Código: $classeNiceCodigo\n";
                    echo "Classe Nice Especificação: $classeNiceEspecificacao\n";
                    echo "Classe Nice Status: $classeNiceStatus\n";
                    echo "Procurador: $procurador\n";
                } else {
                    echo "Processo com número $processoNumero não encontrado.\n";
                }
            }
        

        } catch (Exception $e ) {
            
        }
    }
}
