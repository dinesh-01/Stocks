<?php
require_once './include/common.php';


$trade = new Laratrade\Trader\Trader();

$headers = [
    'Content-Type' => 'application/json',
    'X-Kite-Version' => '3',
    'Authorization' => 'token '.KEY.':'.TOKEN
];

$client = new GuzzleHttp\Client([
    'headers' => $headers
]);


$date = date('d-m-Y');
$minute = date('i');



//Getting all stocks

$query  = "Select cSymbol from stocklistIntra";
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

    $api_symbol = $record[0];

    if(str_contains($api_symbol,"%26")) {
        $api_symbol = str_replace("%26", "&", $api_symbol);
    }

    $fetch = $response['data']["NSE:$api_symbol"]["ohlc"];

    $open = $fetch['open'];
    $open = intval(str_replace(",", "", $open));

    $low = $fetch['low'];
    $low = intval(str_replace(",", "", $low));

    $high = $fetch['high'];
    $high = intval(str_replace(",", "", $high));

    $close = $response['data']["NSE:$api_symbol"]['last_price'];
    $close = intval(str_replace(",", "", $close));

    $prev_close = $fetch['close'];
    $prev_close = intval(str_replace(",", "", $prev_close));


    $volume = $response['data']["NSE:$api_symbol"]['volume'];
    $alllow = 0;
    $allhigh = 0;
    $value = 0;
    $chng_percentage = 0;

    $chng = $close - $prev_close;
    $chng = number_format($chng, 1);

    $open_array[0] = $open;
    $high_array[0] = $high;
    $low_array[0] = $low;
    $close_array[0] = $close;





    /*
    $query = "Select id from stocklistIntra where cSymbol = '$api_symbol' ";
    $result = mysqli_query($GLOBALS['mysqlConnect'], $query);
    $id = $result->fetch_all(MYSQLI_ASSOC);
    $sid = $id[0]['id'];

    $query = "INSERT INTO stockvaluesIntra(sid, open, high, allHigh, low, allLow, close, schange, schangePercent, volume, stockvalues, addClear, createdDate)
VALUES ('$sid','$open','$high','$allhigh','$low','$alllow','$close','$chng','$chng_percentage','$volume','$value',$add_row_data_increment,'$date')";
    $result = mysqli_query($GLOBALS['mysqlConnect'], $query);

    $query = "UPDATE stocklistIntra SET dailyEntry='yes',current_volume='$volume',qbuy='$chng' WHERE id = '$sid'";
    $result = mysqli_query($GLOBALS['mysqlConnect'], $query);

    */

    echo "$api_symbol  Completed - $chng";
    echo "\n";

    $i++;


}














?>
