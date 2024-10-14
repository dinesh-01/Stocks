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
$cat = $_GET['t'];




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


$low_price     = $response['data']["NSE:$symbol"]['ohlc']['low'];
$low_price = str_replace(",", "", $low_price);

$high_price    = $response['data']["NSE:$symbol"]['ohlc']['high'];
$high_price = str_replace(",", "", $high_price);







if($type == 'CE') {
    $query = "Select * from stockOption where name = '$symbol' 
                            and strike > $high_price
                            and tradingsymbol LIKE '%OCT%'
                            and instrument_type = '$type' order by `strike` limit 0,1; ";
}else {
    $query = "Select * from stockOption where name = '$symbol' 
                            and strike < $low_price
                            and tradingsymbol LIKE '%OCT%'
                            and instrument_type = '$type' order by `strike` desc limit 0,1; ";

}



$result = mysqli_query($GLOBALS['mysqlConnect'], $query);
$datas = $result->fetch_all(MYSQLI_ASSOC);
$i = 0;

foreach ($datas as $data) {


    $tradingsymbol = $data['tradingsymbol'];

    $year = explode("-",$data['expiry']);
    $year = substr($year[0], 2);
    $month = explode("-",$data['expiry']);
    $month = $month[1];
    $date = explode("-",$data['expiry']);
    $date = $date[2];
    $ins_type = $data['instrument_type'][0];
    $strike = $data['strike'];


    $tradingsymbol_trading_view = "NSE:".$data['name'].$year.$month.$date.$ins_type.$strike;
    $datas[$i]['url']  = $tradingsymbol_trading_view;


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


    $symbol = $data['tradingsymbol']; //Fetching stock Symbol
    $quantity = $datas[$i]['lot']; //Fetching lot size
    $s = $_GET['s']; //Index
    $o = $_GET['o']; //option_type
    $resistance = '';
    $support = '';

    $date = date('d-m-Y');

    $end_point = "https://api.kite.trade/quote?i=NSE:$s";
    $res = $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response, true));

    //format($response['data']["NSE:$s"]['ohlc']);


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

    $symbol = $_GET['s'];
    $query  = "UPDATE stocklistIntra SET order_status = 'Updated' WHERE cSymbol = '$symbol'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


    $i++;




}




header("location:list_watch.php");
exit;






?>
