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

#reseting the dailyentry
  $query = "UPDATE stocklist SET `dailyEntry`='no', `qbuy`='0',`qvolume`='0',
                     `current_volume`='0',`qtotal`='0',`stock_signal`='=> SELECT <=',
                     `order_type`='LIMIT',`target`='0',`stop_loss`='0' ";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);



$filename = 'data/200.csv'; // Replace with your file name or path
$date = date('d-m-Y');

// Open the CSV file for reading
$file = fopen($filename, 'r');

if ($file) {
    // Read the header row
    $header = fgetcsv($file);


    // Read and output the remaining rows
    while (($row = fgetcsv($file)) !== false) {

        $api_symbol = $row[0];
        $end_point = "https://api.kite.trade/quote?i=NSE:$api_symbol";
        $res = $client->request('GET', $end_point);
        $response = $res->getBody()->getContents();
        $response = (json_decode($response,true));
        $fetch = $response['data']["NSE:$api_symbol"]["ohlc"];

        $open = $fetch['open'];
        $low = $fetch['low'];
        $high = $fetch['high'];
        $close = $response['data']["NSE:$api_symbol"]['last_price'];
        $prev_close = $fetch['close'];
        $volume = $response['data']["NSE:$api_symbol"]['volume'];
        $alllow = 0;
        $allhigh = 0;
        $value = 0;
        $chng_percentage = 0;

        $chng =  $close - $prev_close ;
        $chng = number_format($chng,1);

       $query  = "Select id from stocklist where cSymbol = '$api_symbol' ";
       $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
       $id = $result->fetch_all(MYSQLI_ASSOC);
       $sid = $id[0]['id'];

         $query = "INSERT INTO stockvalues(sid, open, high, allHigh, low, allLow, close, schange, schangePercent, volume, stockValues, addClear, createdDate)
    VALUES ('$sid','$open','$high','$allhigh','$low','$alllow','$close','$chng','$chng_percentage','$volume','$value',1,'$date')";
        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

        $query = "UPDATE stocklist SET dailyEntry='yes',current_volume='$volume' WHERE id = '$sid'";
        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


        echo "$api_symbol  Completed - $chng";
        echo "\n";

        sleep(1);

    }

    // Close the file
    fclose($file);
} else {
    echo "Failed to open the file.";
}


?>
