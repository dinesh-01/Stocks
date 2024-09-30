<?php
require_once './include/common.php';

// setting up end headers
$headers = [
    'Content-Type' => 'application/json',
    'X-Kite-Version' => '3',
    'Authorization' => 'token '.KEY.':'.TOKEN
];

$client = new GuzzleHttp\Client([
    'headers' => $headers
]);


$symbol = $_GET['option_symbol']; //Fetching stock Symbol
$quantity = $_GET['lot_size']; //Fetching lot size
$s = $_GET['s']; //Index
$o = $_GET['o']; //option_type
$i = $_GET['i'];
$resistance = '';
$support = '';

$date = date('d-m-Y');

$end_point = "https://api.kite.trade/quote?i=NSE:$s";
$res = $client->request('GET', $end_point);
$response = $res->getBody()->getContents();
$response = (json_decode($response, true));

format($response['data']["NSE:$s"]['ohlc']);


if($o == 'PE') {
    $support = $response['data']["NSE:$s"]['ohlc']['low'];
    $support  = percentgae_cal($support,"-");
}

if($o == 'CE') {
    $resistance = $response['data']["NSE:$s"]['ohlc']['high'];
    $resistance  = percentgae_cal($resistance,"+");
}




//Update order status
$query  = "INSERT INTO optionAmo( symbol, quanity, support_value, resistance_value, track_status, created_date) VALUES ('$symbol','$quantity','$support','$resistance','Order Pending','$date')";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);



header("location:stock_options_orders.php?s=$s&o=$o");
exit;



?>
