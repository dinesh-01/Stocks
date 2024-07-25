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


//delete SL Order
$sl_order_id = $data['sl_order_id'];

if(!empty($sl_order_id) || !is_null($sl_order_id)) {
    $end_point = "https://api.kite.trade/orders/regular/$order_id";
    $res = $client->request('DELETE',$end_point);
}




$symbol = $data['symbol'];
$quantity = $data['quanity'];

$end_point = "https://api.kite.trade/quote?i=NFO:$symbol";
$res = $client->request('GET', $end_point);
$response = $res->getBody()->getContents();
$response = (json_decode($response, true));

$last_price = $response['data']["NFO:$symbol"]['last_price'];
$last_price = str_replace(",", "", $last_price); //last price


$percentage_value = 0.1 / 100 ;
$amount_value = $last_price * $percentage_value;


$final_amount = round($last_price - $amount_value,1);


$end_point = "https://api.kite.trade/orders/regular";
$res = $client->request('POST', $end_point, [
    'form_params' => [
        'tradingsymbol' => $symbol,
        'exchange' => 'NFO',
        'transaction_type' => "SELL",
        'order_type' => 'LIMIT',
        'price' => $final_amount,
        'quantity' => $quantity,
        'product' => 'NRML',
        'validity' => 'DAY'

    ]
]);



header("location:stock_options_execution.php");
exit;












?>
