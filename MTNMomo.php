<?php
require('BaseApi.php');
require('Users.php');
require('Collections.php');
require('Payments.php');

class MTNMomo {
    public $users;
    public $collections;
    public $payments;

    function __construct($env = null) {
        $this->users = new Users($env);
        $this->collections = new Collections($env);
        $this->payments = new Payments();
    }

    static function withApiKey($apiKey, $env = null) {

    }

}