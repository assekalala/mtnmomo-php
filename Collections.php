<?php

class Collections extends BaseApi {
    
    public $id;
    public $callback;


    public function __construct($env = null) {
        $this->environment = ($env != null) ? $env : 'production';
        $this->setHeader('Content-Type', 'application/json');
        $this->setHeader('X-Target-Environment', $this->environment);
    }

    public function request($amount, $from, $txnId, $reason, $callback, $currency='EUR') {
        
        $data = array(
            'amount' => $amount,
            'currency' => $currency,
            'externalId' => $txnId,
            'payer' => array(
                'partyIdType' => 'MSISDN',
                'partyId' => $from
            ),
            'payerMessage' => $reason,
            'payeeNote' => $reason,
        );

        $this->setHeader('X-Reference-Id', $txnId);
        $this->setHeader('X-Callback-Url', $callback);
        $endpoint = $this->baseUrl . '/collection/v1_0/requesttopay';
        $result = $this->sendRequest('POST', $endpoint, $data);
        return $result;
    }
}