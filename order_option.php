<?php
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


    $symbol = $_GET['option_symbol']; //Fetching stock Symbol
    $quantity = $_GET['lot_size']; //Fetching lot size
    $s = $_GET['s']; //Index
    $o = $_GET['o']; //option_type
    $i = $_GET[i];

    $date = date('d-m-Y');
    $date_param = date('Y-m-d');
    $date_param = "2024-08-16";
    $time_frame = TIME_FRAME.'minute';


    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);

    $end_point = "https://api.kite.trade/instruments/historical/$i/$time_frame?from=$date_param+09:15:00&to=$date_param+15:30:00";
    $res = $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));

    //format($response);



    $length = count($response['data']['candles']);
    $length =  $length-1;
    $trigger_value =  $response['data']['candles'][$length][2];



   //Update order status
   $query  = "INSERT INTO optionAmo(symbol, quanity, trigger_value, track_status, created_date) VALUES ('$symbol','$quantity','$trigger_value','Order Pending','$date')";
   $result = mysqli_query($GLOBALS['mysqlConnect'],$query);



   if($s == "MIDCPNIFTY") {
       $s="MIDCP";
   }

    header("location:stock_global_options_orders.php?s=$s&o=$o");
    exit;


?>
