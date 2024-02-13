<?php

//including common files
require_once './include/common.php';

$s = $_GET['s'];

// setting up end headers
$headers = [
    'Content-Type' => 'application/json',
    'X-Kite-Version' => '3',
    'Authorization' => 'token '.KEY.':'.TOKEN
];

$client = new GuzzleHttp\Client([
    'headers' => $headers
]);

$end_point = "https://api.kite.trade/margins/futures";
$res = $client->request('GET', $end_point);
$response = $res->getBody()->getContents();
$response = (json_decode($response, true));


foreach ($response as $data) {

    $tradingsymbol = $data['tradingsymbol'];
    $strike = $data['nrml_margin'];

    $query = "UPDATE `stockFuture` SET `strike`='$strike' WHERE `tradingsymbol` = '$tradingsymbol' ";
    $result = mysqli_query($GLOBALS['mysqlConnect'], $query);

}

header("location:stock_future_orders.php?s=$s");
exit;

?>