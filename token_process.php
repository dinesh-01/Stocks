<?php

require_once './include/common.php';

$client = new GuzzleHttp\Client();

$api_key = "asx9hj1ykmv09kgc";
$token   = $_POST['token'];
$api_auth_key = "brdcvwvmgbsb9oi9hpcgn9xj4mqmmbq0";

$key = $api_key.$token.$api_auth_key;

$hash = hash('sha256',$key);



$res = $client->request('POST', 'https://api.kite.trade/session/token', [
    'form_params' => [
        'api_key' => $api_key,
        'request_token' => $token,
        'checksum' => $hash,
    ]
]);


$json = $res->getBody();
$decoded_json = json_decode($json, false);
$final_token =  $decoded_json->data->access_token;
header("location:token.php?token_name=$final_token");
exit;


?>
