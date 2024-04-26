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


  #reseting the order_status
  $query = "UPDATE stocklistbackup SET `order_status`='0' ";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

  $delete_query = "DELETE FROM stockvaluesbackup WHERE `createdDate` = '$date'";
  $delete_result = mysqli_query($GLOBALS['mysqlConnect'],$delete_query);



  //Getting all stocks

  $query  = "Select cSymbol from stocklistbackup";
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
    $open = str_replace(",", "", $open);

    $low = $fetch['low'];
    $low = str_replace(",", "", $low);

    $high = $fetch['high'];
    $high = str_replace(",", "", $high);

    $close = $response['data']["NSE:$api_symbol"]['last_price'];
    $close = str_replace(",", "", $close);

    $prev_close = $fetch['close'];
    $prev_close = str_replace(",", "", $prev_close);


    $volume = $response['data']["NSE:$api_symbol"]['volume'];
    $alllow = 0;
    $allhigh = 0;
    $value = 0;
    $chng_percentage = 0;

    $chng = $close - $prev_close;
    $chng = number_format($chng, 1);



    $query = "Select id from stocklistbackup where cSymbol = '$api_symbol' ";
    $result = mysqli_query($GLOBALS['mysqlConnect'], $query);
    $id = $result->fetch_all(MYSQLI_ASSOC);
    $sid = $id[0]['id'];

    $query = "INSERT INTO stockvaluesbackup(sid, open, high, allHigh, low, allLow, close, schange, schangePercent, volume, stockvaluesbackup, addClear, createdDate)
VALUES ('$sid','$open','$high','$allhigh','$low','$alllow','$close','$chng','$chng_percentage','$volume','$value',1,'$date')";
    $result = mysqli_query($GLOBALS['mysqlConnect'], $query);

    $query = "UPDATE stocklistbackup SET dailyEntry='yes',current_volume='$volume',qbuy='$chng' WHERE id = '$sid'";
    $result = mysqli_query($GLOBALS['mysqlConnect'], $query);



    echo "$api_symbol  Completed - $chng";
    echo "\n";

    $i++;


}















?>
