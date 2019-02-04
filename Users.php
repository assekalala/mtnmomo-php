<?php

class Users extends BaseApi {

    public $id;

    public function __construct($env = null) {

    }

    public function createUser($userId, $callbackHost) {
        $endpoint = $this->baseUrl . '/v1_0/apiuser';

        $this->setHeader('X-Reference-Id', $userId);
        $this->setHeader('Content-Type', 'application/json');
        $data = array('providerCallbackHost' => $callbackHost);
        $data_string = json_encode($data);

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $result = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return ($httpcode === 201 | $httpcode === 200) ? True : False;
    }

    public function getUser($userId) {
        $url = $this->baseUrl . '/v1_0/apiuser/'. $userId;
        $this->sendRequest('GET', $url);
    }

    public function getApiKey($userId) {
        $url = $this->baseUrl . '/v1_0/apiuser/'. $userId . '/apikey';
        $result = $this->sendRequest('GET', $url);

        $json = json_decode($result);

        if (isset($json['apiKey'])) {
            $this->apiUserId = $userId;
            $this->apiKey = $json['apiKey'];
            
            return $json['apiKey'];
        } else {
            return null;
        }
    }
}