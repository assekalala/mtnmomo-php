<?php

require('MTNMomo.php');

$momo = new MTNMomo('sandbox');
// $uuid = BaseApi::generate_uuid();
// $userId = 'abdu';
// $callbackHost = 'example.com';
// $momo->users->setSubscriptionKey('ea3f49f42aef4257969ce43db047466f');
// if($momo->users->createUser($uuid, $callbackHost)) {
//     $momo->users->getApiKey($uuid);
// } else {
//     echo 'Failed creating api user '. $uuid;
// }

// collections
$momo->collections->setSubscriptionKey('ea3f49f42aef4257969ce43db047466f');
// $result = $momo->collections->request(500, 256787133968, 'TXN12345', 'Test', 'https://example.com');
// $result = $momo->collections->getTransactionStatus('TXN3232');
$result = $momo->collections->getBalance();
// echo $result;


// payements
// $momo->payments->setSubscriptionKey('e2cbf7a330ce426da7d313caac9c050a');
// $momo->payments->pay(256787133968, 5000, 'Test', 'txn3423');
?>