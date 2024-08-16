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

    $date = date('d-m-Y');

   //Update order status
   $query  = "INSERT INTO optionAmo(symbol, quanity, track_status, created_date) VALUES ('$symbol','$quantity','Order Pending','$date')";
   $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


   if($s == "MIDCPNIFTY") {
       $s="MIDCP";
   }

    header("location:stock_global_options_orders.php?s=$s&o=$o");
    exit;


?>
