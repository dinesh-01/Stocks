<?php
require_once './include/common.php';


$headers = [
    'Content-Type' => 'application/json',
    'X-Kite-Version' => '3',
    'Authorization' => 'token '.KEY.':'.TOKEN
];

$client = new GuzzleHttp\Client([
    'headers' => $headers
]);



$query  = "Select id,cSymbol from stocklistfutures";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$data    = mysqli_fetch_all($result, MYSQLI_ASSOC);


$date = date('d-m-Y');



    // Read and output the remaining rows
    foreach ($data as $value) {

        $sid = $value['id'];
        $api_symbol = $value['cSymbol'];
        $end_point = "https://api.kite.trade/quote?i=NFO:$api_symbol";
        $res = $client->request('GET', $end_point);
        $response = $res->getBody()->getContents();
        $response = (json_decode($response,true));
        $fetch = $response['data']["NFO:$api_symbol"]["ohlc"];

        $open = $fetch['open'];
        $open = str_replace(",","",$open);

        $low = $fetch['low'];
        $low = str_replace(",","",$low);

        $high = $fetch['high'];
        $high = str_replace(",","",$high);

        $close = $response['data']["NFO:$api_symbol"]['last_price'];
        $close = str_replace(",","",$close);


        $prev_close = $fetch['close'];
        $prev_close = str_replace(",","",$prev_close);

        $volume = $response['data']["NFO:$api_symbol"]['volume'];

        $alllow = 0;
        $allhigh = 0;
        $value = 0;
        $chng_percentage = 0;

        $chng =  $close - $prev_close ;
        $chng = number_format($chng,1);


         $query = "INSERT INTO stockvaluesfutures(sid, open, high, allHigh, low, allLow, close, schange, schangePercent, volume, stockValues, addClear, createdDate)
    VALUES ('$sid','$open','$high','$allhigh','$low','$alllow','$close','$chng','$chng_percentage','$volume','$value',1,'$date')";
        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

        echo "$api_symbol  Completed - $chng";
        echo "\n";


    }


?>
