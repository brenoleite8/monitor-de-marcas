<?php

class PagamentoServiceProvider{
    
    private $service;
    private $gatewayPagamento;
    
    function __construct(GatewayPagamento $gatewayPagamento)
    {
        $this->gatewayPagamento = $gatewayPagamento;
        
        if($gatewayPagamento->id == GatewayPagamento::MERCADO_PAGO)
        {
            $this->service = new MercadoPagoService($gatewayPagamento);
        }
        else if($gatewayPagamento->id == GatewayPagamento::BANCO_INTER)
        {
            $this->service = new BancoInterService($gatewayPagamento);
        }
    }
    
    public function gerarBoletoPix($dadosCobranca)
    {
        return $this->service->gerarBoletoPix($dadosCobranca);
    }
    
    public function getBoletoPixPdf($codigo)
    {
        return $this->service->getBoletoPixPdf($codigo);
    }
    
    public function gerarLinkCheckoutExterno($itens, $cobranca_id = null)
    {
        return $this->service->gerarLinkCheckoutExterno($itens, $cobranca_id);
    }
    
    public function buscaCobranca(Cobranca $cobranca)
    {
        return $this->service->buscaCobranca($cobranca);
    }
    
    public function criarWebhook()
    {
        return $this->service->criarWebhook();
    }
    
    public function getWebhookCadastrado()
    {
        return $this->service->getWebhookCadastrado();
    }
    
    public function getWebhookCallbacksEnviados($filter)
    {
        return $this->service->getWebhookCallbacksEnviados($filter);
    }
}