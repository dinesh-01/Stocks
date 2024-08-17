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


$global = $_GET['s'];
$type = $_GET['o'];
$cat = $_GET['t'];
$allocate_price = ALLOCATE_PRICE;


if($global == 'NIFTY') {
    $symbol = "NIFTY 50";
    $end_point = "https://api.kite.trade/quote?i=NSE:$symbol";
    $expiry = '2024-08-29%';
   // $allocate_price = EXPIRY_ALLOCATE_PRICE;

}

if($global == 'BANKNIFTY') {
    $symbol = "NIFTY BANK";
    $end_point = "https://api.kite.trade/quote?i=NSE:$symbol";
    $expiry = '2024-08-28%';

}

if($global == 'MIDCP') {
    $symbol = "NIFTY MID SELECT";
    $end_point = "https://api.kite.trade/quote?i=NSE:$symbol";
    $expiry = '2024-08-26%';
}


if($global == 'FINNIFTY') {
    $symbol = "NIFTY FIN SERVICE";
    $end_point = "https://api.kite.trade/quote?i=NSE:$symbol";
    $expiry = '2024-08-27%';


}


if($global == 'NIFTYNXT50') {
    $symbol = "NIFTY NEXT 50";
    $end_point = "https://api.kite.trade/quote?i=NSE:$symbol";
    $expiry = '2024-05-31%';

}




$res = $client->request('GET', $end_point);
$response = $res->getBody()->getContents();
$response = (json_decode($response, true));
$current_price = $response['data']["NSE:$symbol"]['last_price'];
$current_price = str_replace(",", "", $current_price);


$percentage_value = 1 / 100 ;
$amount_value = $current_price * $percentage_value;


$final_amount = $current_price + $amount_value;
$range2 = round($final_amount, 0);

$final_amount = $current_price - $amount_value;
$range1 = round($final_amount, 0);




if($type == "PE") {
    $orderBy = "desc";
    $query = "SELECT * FROM `stockOption` WHERE `tradingsymbol` LIKE '$global%' 
                                and `expiry` LIKE '$expiry'
                                and strike BETWEEN $current_price AND $range2 
                                and instrument_type = '$type' order by strike $orderBy";

}else{
    $orderBy = "asc";
     $query = "SELECT * FROM `stockOption` WHERE `tradingsymbol` LIKE '$global%' 
                                and `expiry` LIKE '$expiry'
                                and strike BETWEEN $range1 AND $current_price 
                                and instrument_type = '$type' order by strike $orderBy";

}





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
    $datas[$i]['volume'] = $response["data"]["NFO:".$tradingsymbol]["volume"];
    $datas[$i]['last_price'] = $last_price;
    $datas[$i]['instrument_token'] = $data['instrument_token'];

    $amount = $last_price * $data['lot_size'];
    $lot    = ($allocate_price / $amount) ;
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
