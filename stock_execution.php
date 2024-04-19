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
$query = "Select * from stockAmo";
$result = mysqli_query($GLOBALS['mysqlConnect'], $query);
$datas = $result->fetch_all(MYSQLI_ASSOC);
$i = 0;
$amount = 0;
foreach ($datas as $data) {


    $tradingsymbol = $data['symbol'];


    if(str_contains($tradingsymbol,"&")) {
        $option_tradingsymbol = str_replace("&", "%26", $tradingsymbol);
        $end_point = "https://api.kite.trade/quote?i=NSE:$option_tradingsymbol";
    }else{
        $end_point = "https://api.kite.trade/quote?i=NSE:$tradingsymbol";
    }

    $res = $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response, true));


    $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$tradingsymbol);
    $stock_symbol = $arr[0];
    $stock_symbol = preg_replace('/\d/', '', $stock_symbol );


    $last_price = $response["data"]["NSE:".$tradingsymbol]["last_price"];
    $datas[$i]['last_price'] = round($last_price, 1);
    $datas[$i]['stock_symbol'] = $stock_symbol;
    $datas[$i]['price_diff'] = $last_price - $data['price'];
    $datas[$i]['amount_diff'] = round($datas[$i]['price_diff'],1) *  $data['quanity'];
    $datas[$i]['invested'] = intval($data['price'] * $data['quanity']);
    $amount = $amount +  $datas[$i]['invested'];

    //Actuall profit or loss
    $commission_amount = $datas[$i]['amount_diff'] * 0.25;

    if($datas[$i]['amount_diff'] > 0) {
        $actual_profit_loss = $datas[$i]['amount_diff'] - $commission_amount;
    }else{
        $actual_profit_loss = $datas[$i]['amount_diff'] + $commission_amount;
    }





    $datas[$i]['actual_profit_loss'] = round($actual_profit_loss);


    $i++;

}





//List all the option orders
$query = "Select * from stockIncome";
$result = mysqli_query($GLOBALS['mysqlConnect'], $query);
$results = $result->fetch_all(MYSQLI_ASSOC);
$ledgers = 0;
foreach ($results as $result) {
    $ledgers = $ledgers + $result['amount'];
}



$smarty->assign("datas",$datas);
$smarty->assign("total_invested",$amount);
$remaining = 300000 - $amount;
$smarty->assign("remaining_invested",$remaining);
$smarty->assign("ledger",$ledgers);
$smarty->display("show_execution.tpl");



?>
