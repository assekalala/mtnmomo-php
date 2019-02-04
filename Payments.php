<?php


class Payments extends BaseApi {

    public function __construct($env = null) {
        $this->environment = ($env != null) ? $env : 'production';
        $this->setHeader('Content-Type', 'application/json');
        $this->setHeader('X-Target-Environment', $this->environment);
    }

    public function pay($subscriber, $amount, $reason, $txnId, $currency = 'EUR') {
        $data = array(
            'amount' => $amount,
            'currency' => $currency,
            'externalId' => $txnId,
            'payer' => array(
                'partyIdType' => 'MSISDN',
                'partyId' => $subscriber
            ),
            'payerMessage' => $reason,
            'payeeNote' => $reason,
        );

        $endpoint = $this->baseUrl . "/v1_0/transfer";
        $result = $this->sendRequest('POST', $endpoint, $data);
        return $result;
    }
}