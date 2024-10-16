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



//List all the option orders
$query = "Select * from futureAmo";
$result = mysqli_query($GLOBALS['mysqlConnect'], $query);
$datas = $result->fetch_all(MYSQLI_ASSOC);
$i = 0;

foreach ($datas as $data) {


    $tradingsymbol = $data['symbol'];


    if(str_contains($tradingsymbol,"&")) {
        $option_tradingsymbol = str_replace("&", "%26", $tradingsymbol);
        $end_point = "https://api.kite.trade/quote?i=NFO:$option_tradingsymbol";
    }else{
        $end_point = "https://api.kite.trade/quote?i=NFO:$tradingsymbol";
    }


    $res = $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response, true));


    $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$tradingsymbol);
    $stock_symbol = $arr[0];
    $stock_symbol = preg_replace('/\d/', '', $stock_symbol );


    $last_price = $response["data"]["NFO:".$tradingsymbol]["last_price"];
    $datas[$i]['last_price'] = round($last_price, 1);
    $datas[$i]['stock_symbol'] = $stock_symbol;
    $datas[$i]['price_diff'] = $last_price - $data['price'];
    $datas[$i]['amount_diff'] = round($datas[$i]['price_diff'],1) *  $data['quanity'];

    //Expected profit
    $datas[$i]['expected_profit'] = round(($data['target'] - $data['price']),1) *  $data['quanity'];



    $i++;

}


$smarty->assign("datas",$datas);
$smarty->display("show_futures_execution.tpl");



?>
