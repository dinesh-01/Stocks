
<?php

//including common files

require_once './include/common.php';
require_once './template/header.php';



$headers = [
    'Content-Type' => 'application/json',
    'X-Kite-Version' => '3',
    'Authorization' => 'token '.KEY.':'.TOKEN
];

$client = new GuzzleHttp\Client([
    'headers' => $headers
]);


$date = date('d-m-Y');

//Getting all stocks

$query  = "SELECT `cSymbol`,`support_value`,`grow`, `support_signal`,`id`,`isWatch` from stocklistIntra";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$row    = mysqli_fetch_all($result);
$i = 1;

//Concating all stocks at onces
foreach ($row as $record) {

    $api_symbol = $record[0];

    if (str_contains($api_symbol, "&")) {
        $api_symbol = str_replace("&", "%26", $api_symbol);
    }


    $all_stocks[] = "i=NSE:" . $api_symbol;

}


//Got all data from kite instruments
$all_stocks = implode("&",$all_stocks);
$end_point = "https://api.kite.trade/quote?$all_stocks";
$res = $client->request('GET', $end_point);
$response = $res->getBody()->getContents();
$response = (json_decode($response, true));


//Updating in Database
foreach ($row as $record) {

    $api_symbol    = $record[0];
    $support_value = $record[1];
    $grow          = $record[2];
    $support_signal = $record[3];
    $id = $record[4];
    $watch_status = $record[5];


    if(str_contains($api_symbol,"%26")) {
        $api_symbol = str_replace("%26", "&", $api_symbol);
    }


    $close = $response['data']["NSE:$api_symbol"]['last_price'];
    $last_price = str_replace(",", "", $close);



    if(!is_null($support_value) || !empty($support_value)) {

        if ( ($last_price <= $support_value) || ($support_signal == 1) ) {

            $match[$i]['cSymbol'] = $api_symbol;
            $match[$i]['last_price'] = $last_price;
            $match[$i]['support_value'] = $support_value;
            $match[$i]['grow'] = $grow;
            $match[$i]['id'] = $id;
            $match[$i]['isWatch'] = $watch_status;


            $query  = "UPDATE `stocklistIntra` SET `support_signal`='1' WHERE `cSymbol` = '$api_symbol'";
            $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


        }

    }


    $i++;


}



//Rending to tbl file
$smarty->assign("datas",$match);
$smarty->display("support_monitor.tpl");

?>
