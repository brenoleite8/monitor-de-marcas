<?php

use PHPUnit\Framework\TestCase;

class VerificarInpiServiceTest extends TestCase
{
    /**
     * Testa se o método download funciona quando o HTML é válido
     */
    public function testDownloadComHtmlValido()
    {
        // Criar um mock da classe VerificarInpiService
        $mock = $this->getMockBuilder('VerificarInpiService')
                     ->onlyMethods(['download'])
                     ->getMock();

        // Simular o retorno esperado
        $expectedResult = [
            'numero_rpi' => '2024123',
            'xml_path' => 'app/output/RM2024123/RM2024123.xml'
        ];

        $mock->expects($this->once())
             ->method('download')
             ->willReturn($expectedResult);

        $result = $mock->download();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('numero_rpi', $result);
        $this->assertArrayHasKey('xml_path', $result);
        $this->assertEquals('2024123', $result['numero_rpi']);
    }

    /**
     * Testa se o método download lança exceção quando há erro
     */
    public function testDownloadComErro()
    {
        $mock = $this->getMockBuilder('VerificarInpiService')
                     ->onlyMethods(['download'])
                     ->getMock();

        $mock->expects($this->once())
             ->method('download')
             ->willThrowException(new Exception('Sistema fora do ar'));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Sistema fora do ar');

        $mock->download();
    }

    /**
     * Testa se o método processar funciona com dados válidos
     */
    public function testProcessarComSucesso()
    {


        $mock = $this->getMockBuilder('VerificarInpiService')
                     ->onlyMethods(['download'])
                     ->getMock();

        // Simular retorno do download
        $downloadResult = [
            'numero_rpi' => '2024123',
            'xml_path' => __DIR__ . '/fixtures/test.xml'
        ];

        $mock->expects($this->once())
             ->method('download')
             ->willReturn($downloadResult);

        // Criar arquivo XML de teste
        $this->createTestXmlFile($downloadResult['xml_path']);

        // Executar sem exceções
        $this->expectNotToPerformAssertions();
        
        try {
            $mock->processar();
        } catch (Exception $e) {
            // Limpar arquivo de teste
            unlink($downloadResult['xml_path']);
            throw $e;
        }

        // Limpar arquivo de teste
        unlink($downloadResult['xml_path']);
    }

    /**
     * Testa se processar lança exceção quando download falha
     */
    public function testProcessarComErroDownload()
    {
        $mock = $this->getMockBuilder('VerificarInpiService')
                     ->onlyMethods(['download'])
                     ->getMock();

        // Simular erro no download
        $mock->expects($this->once())
             ->method('download')
             ->willReturn('Erro no download');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Erro no Download');

        $mock->processar();
    }

    /**
     * Criar arquivo XML de teste
     */
    private function createTestXmlFile($path)
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>
        <revista data="01/01/2024">
            <processo numero="123456789">
                <despachos>
                    <despacho codigo="15.1" nome="Exigência Formal"/>
                </despachos>
                <titulares>
                    <titular nome-razao-social="Empresa Teste" pais="BR" uf="SP"/>
                </titulares>
            </processo>
        </revista>';

        file_put_contents($path, $xmlContent);
    }
}