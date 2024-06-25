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

$query = "SELECT `sl_order_id`,`order_id` FROM `optionAmo` where order_id='$order_id'";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$data = mysqli_fetch_row($result);
$sl_id =  $data[0];


/*

//Fetch Order_Status
$end_point = "https://api.kite.trade/orders/$order_id";
$res = $client->request('GET', $end_point);

$response = $res->getBody()->getContents();
$response = (json_decode($response,true));
$length   = count($response['data']);
$length   =  $length-1;
$order_status = $response['data'][$length]['status'];


if($order_status == "COMPLETE") {
    //delete SL Order
     $end_point = "https://api.kite.trade/orders/regular/$sl_id";
     $res = $client->request('DELETE',$end_point);
}

//Fetch SL Status
$end_point = "https://api.kite.trade/orders/$sl_id";
$res = $client->request('GET', $end_point);

$response = $res->getBody()->getContents();
$response = (json_decode($response,true));
$length   = count($response['data']);
$length   =  $length-1;
$sl_order_status = $response['data'][$length]['status'];


if($sl_order_status == "COMPLETE") {
    //delete SL Order
    $end_point = "https://api.kite.trade/orders/regular/$order_id";
    $res = $client->request('DELETE',$end_point);
}

*/

$query = "DELETE from optionAmo where order_id='$order_id'";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);


header("location:stock_options_execution.php");
exit;













?>
