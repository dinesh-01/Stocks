<?php

//including common files
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


$end_point = "https://api.kite.trade/instruments/NFO";
$res = $client->request('GET', $end_point);
$response = $res->getBody()->getContents();
$future_list = explode(PHP_EOL, $response);

foreach ($future_list as $list) {

    if(str_contains($list,"NFO-OPT")) {
        $list = str_replace('"','',$list);
        $entry =  explode(",", $list);

        //stock futures entry
        $query  = "INSERT INTO stockOption(instrument_token, exchange_token, tradingsymbol, name, last_price, expiry, strike, tick_size, lot_size, instrument_type, segment, exchan)
        VALUES ('$entry[0]','$entry[1]','$entry[2]','$entry[3]','$entry[4]','$entry[5]','$entry[6]','$entry[7]','$entry[8]','$entry[9]','$entry[10]','$entry[11]')";
        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

        echo $entry[2]." Completed";
        echo "\n";


    }

}


?>
