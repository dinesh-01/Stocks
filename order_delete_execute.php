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


$query = "SELECT `symbol`,`price`,`quanity` FROM `stockAmoIntra` where order_id='$order_id'";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$data = mysqli_fetch_row($result);
$symbol = $data[0];
$order_price =  $data[1];
$quanity = $data[2];


//Get Last traded price
$end_point = "https://api.kite.trade/orders/$order_id";
$res = $client->request('GET',$end_point);
$response = $res->getBody()->getContents();
$response = (json_decode($response, true));
$length = count($response['data']);
$length =  $length-1;


//Fetching average price
$average_price = $response['data'][$length]['average_price'];
$date = date('d-m-Y');
$tran_price = $average_price - $order_price;
$result_price = $quanity * $tran_price;

$query = "DELETE from stockAmoIntra where order_id='$order_id'";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

echo $query = "INSERT INTO `stockIncome` ( `symbol`, `amount`, `createdDate`) VALUES ('$symbol', '$result_price', '$date')";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);


header("location:stock_execution.php");
exit;













?>
