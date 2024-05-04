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



$date = date('d-m-Y');

$delete_query = "DELETE FROM stockvaluesIntrafutures WHERE `createdDate` = '$date'";
$delete_result = mysqli_query($GLOBALS['mysqlConnect'],$delete_query);

$query  = "Select id,cSymbol from stocklistIntrafutures";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$data    = mysqli_fetch_all($result, MYSQLI_ASSOC);

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

        echo $volume." => Volume";
        echo "\n";

        $alllow = 0;
        $allhigh = 0;
        $value = 0;
        $chng_percentage = 0;

        $chng =  $close - $prev_close ;
        $chng = number_format($chng,1);


         $query = "INSERT INTO stockvaluesIntrafutures(sid, open, high, allHigh, low, allLow, close, schange, schangePercent, volume, stockvaluesIntra, addClear, createdDate)
    VALUES ('$sid','$open','$high','$allhigh','$low','$alllow','$close','$chng','$chng_percentage','$volume','$value',2,'$date')";
        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

        $query = "UPDATE stocklistIntrafutures SET current_volume='$volume' WHERE id = '$sid'";
        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


        echo "$api_symbol  Completed - $chng";
        echo "\n";
        sleep(1);




    }


?>
