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

//Fetching stock Symbol
$order_id = $_GET['id'];
$query    = "SELECT * from stockAmoIntra where order_id='$order_id'";
$result   = mysqli_query($GLOBALS['mysqlConnect'],$query);
$data     = mysqli_fetch_assoc($result);


$symbol = $data['symbol'];
$quantity = $data['quanity'];



$end_point = "https://api.kite.trade/quote?i=NSE:$symbol";
$res = $client->request('GET', $end_point);
$response = $res->getBody()->getContents();
$response = (json_decode($response, true));

$last_price = $response['data']["NSE:$symbol"]['last_price'];
$last_price = str_replace(",", "", $last_price); //last price



//Place Order
$end_point = "https://api.kite.trade/orders/regular/$order_id";

$res = $client->request('PUT', $end_point, [
    'form_params' => [
        'order_type' => 'MARKET',
        'quantity' => $quantity,
        'validity' => 'DAY'

    ]
]);

$response = $res->getBody()->getContents();
$response = (json_decode($response,true));


//Fetching order id
$order_id = $response['data']['order_id'];

//Fetch Average Price
$end_point = "https://api.kite.trade/orders/$order_id";
$res = $client->request('GET', $end_point);

$response = $res->getBody()->getContents();
$response = (json_decode($response,true));


$length = count($response['data']);
$length =  $length-1;

$price = $response['data'][$length]['average_price'];
$price = str_replace(",", "", $price); //last price
$price =  number_format($price,1);





$query = "UPDATE `stockAmoIntra` SET `target`='$price' WHERE order_id='$order_id'";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

header("location:stock_execution.php");
exit;













?>
