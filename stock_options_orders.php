<?php

//including common files
require_once './template/header.php';
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


$symbol = $_GET['s'];
$type = $_GET['o'];

if(str_contains($symbol,"_")) {
    $symbol = str_replace("_", "&", $symbol);
    $api_symbol = str_replace("&", "%26", $symbol);
    $end_point = "https://api.kite.trade/quote?i=NSE:$api_symbol";
}else{
    $end_point = "https://api.kite.trade/quote?i=NSE:$symbol";
}


$res = $client->request('GET', $end_point);
$response = $res->getBody()->getContents();
$response = (json_decode($response, true));
$current_price = $response['data']["NSE:$symbol"]['last_price'];
$current_price = str_replace(",", "", $current_price);


$percentage_value = 2 / 100 ;
$amount_value = $current_price * $percentage_value;


$final_amount = $current_price + $amount_value;
$range2 = round($final_amount, 0);

$final_amount = $current_price - $amount_value;
$range1 = round($final_amount, 0);



 $query = "Select * from stockOption where name = '$symbol' 
                            and strike BETWEEN $range1 AND $range2 
                            and tradingsymbol LIKE '%APR%'
                            and instrument_type = '$type' ";
$result = mysqli_query($GLOBALS['mysqlConnect'], $query);
$datas = $result->fetch_all(MYSQLI_ASSOC);
$i = 0;

foreach ($datas as $data) {


    $tradingsymbol = $data['tradingsymbol'];


    if(str_contains($tradingsymbol,"&")) {
        $option_tradingsymbol = str_replace("&", "%26", $tradingsymbol);
        $end_point = "https://api.kite.trade/quote?i=NFO:$option_tradingsymbol";
    }else{
        $end_point = "https://api.kite.trade/quote?i=NFO:$tradingsymbol";
    }


    $res = $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response, true));


    $last_price = $response["data"]["NFO:".$tradingsymbol]["last_price"];
    $datas[$i]['last_price'] = $last_price;

    $amount = $last_price * $data['lot_size'];
    $lot    = (ALLOCATE_PRICE / $amount) ;
    $lot    = (int)$lot; //quantity
    $datas[$i]['lot'] = $lot * $data['lot_size'];


    $query  = "Select id from optionAmo where symbol='$tradingsymbol'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
    $row = mysqli_num_rows($result);

    if($row) {
        $datas[$i]['order_status'] = "1";
    } else {
        $datas[$i]['order_status'] = "0";
    }

    $i++;

    $details['stock_price'] = $current_price;
    $details['name'] = $data['name'];





}



$smarty->assign("datas",$datas);
$smarty->assign("details",$details);

$smarty->display("show_options_orders.tpl");



?>
