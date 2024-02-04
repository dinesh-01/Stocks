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
$query    = "SELECT * from optionAmo where order_id='$order_id'";
$result   = mysqli_query($GLOBALS['mysqlConnect'],$query);
$data     = mysqli_fetch_assoc($result);


$symbol = $data['symbol'];
$quantity = $data['quanity'];



$end_point = "https://api.kite.trade/quote?i=NFO:$symbol";
$res = $client->request('GET', $end_point);
$response = $res->getBody()->getContents();
$response = (json_decode($response, true));

$last_price = $response['data']["NFO:$symbol"]['last_price'];
$last_price = str_replace(",", "", $last_price); //last price



$percentage_value = 0.5 / 100 ;
$amount_value = $last_price * $percentage_value;
$final_amount = $last_price - $amount_value;
$final_amount = round($final_amount, 1);



//Place Order
$end_point = "https://api.kite.trade/orders/regular/$order_id";

$res = $client->request('PUT', $end_point, [
    'form_params' => [
        'order_type' => 'LIMIT',
        'quantity' => $quantity,
        'price' => $final_amount,
        'validity' => 'DAY'

    ]
]);

$response = $res->getBody()->getContents();
$response = (json_decode($response,true));


$query = "UPDATE `optionAmo` SET `target`='$final_amount' WHERE order_id='$order_id'";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

header("location:stock_options_execution.php");
exit;













?>
