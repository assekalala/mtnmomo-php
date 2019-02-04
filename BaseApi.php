<?php

class BaseApi {
    public $url;
    public $method;
    public $headers = array();
    public $data;
    public $timestamp;

    public $baseUrl = "https://ericssonbasicapi2.azure-api.net";
    public $environment;
    public $subscriptionKey;

    public $endpoint;

    public $apiUserId;
    public $apiKey;

    public function __construct() {
       
    }


    public function setHeader($key, $value) {
        array_push($this->headers, $key.": ".$value);
    }


    public function get_nonce() {
        $uuid = $this->generate_uuid();
        $this->nonce = str_replace('-', '', $uuid);
        return $this->nonce;
    }

    public function get_timestamp() {
        $this->timestamp = time();
        return $this->timestamp;
    }


    public function setEnviroment($env) {
        $this->setHeader('X-Target-Environment', $env);
    }

    public function sendRequest($method = 'GET', $url, $data = null) {

        if($method === 'GET' && $data != null) {
            if (is_array($data)) {
                $url .= '?'. http_build_query($data);
            } else {
                $url .= $data;
            }
        }

        $ch = curl_init($url);
        print_r($url);

        if($method === "POST") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

            if ($data != null) {
                $data_string = json_encode($data);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            }
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        print_r($this->headers);

        $result = curl_exec($ch);
        print_r($result);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($httpcode > 200 && $httpcode < 300) {
            return $result;
        } else {
            echo "Invalid response from API ". $httpcode;
            return null;
        }

        return $result;
    }

    public static function generate_uuid() {
        // $uuid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        //     mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        //     mt_rand( 0, 0xffff ),
        //     mt_rand( 0, 0x0fff ) | 0x4000,
        //     mt_rand( 0, 0x3fff ) | 0x8000,
        //     mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        // );

        // return str_replace("-", "", $uuid);
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');

        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function setSubscriptionKey($subscriptionKey) {
        $this->subscriptionKey = $subscriptionKey;
        $this->setHeader('Ocp-Apim-Subscription-Key', $subscriptionKey);
    }

    public function getToken() {
        $this->setHeader('Authorization', base64_encode($this->apiUserId.':'.$this->apiKey));
        $this->sendRequest('POST', $url);
    }

    public function getTransactionStatus($transactionId) {
        $url = $this->baseUrl . "/collection/v1_0/requesttopay/";
        $data = $transactionId;
        return $this->sendRequest('GET', $url, $data);
    }

    public function getBalance() {
        $url = $this->baseUrl . "/collection/v1_0/account/balance";
        return $this->sendRequest('GET', $url);
    }
}