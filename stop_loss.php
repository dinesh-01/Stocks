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


$field     =  array("id,order_id,symbol,price,quanity,stop_loss,target,created_date");
$table     =  "stockAmo";
$arugment  =  array( "field" => $field , "table" => $table);
$data      =  select($arugment,"many");


foreach ($data as $value) {

    $order_id = $value['order_id'];
    $symbol   = $value['symbol'];
    $quantity = $value['quanity'];

    #fetch order details
    $end_point = "https://api.kite.trade/orders/$order_id";
    $res = $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));
    $index = sizeof($response['data']) - 1;
    $result = $response['data'][$index];
    $last_price = $result['average_price'];


    $stop_loss_percentage = (0.5/100) ;
    $stop_loss_diff =  $last_price * $stop_loss_percentage;
    $stop_loss = $last_price - $stop_loss_diff;
    $stop_loss = number_format($stop_loss ,1);
    $stop_loss = str_replace(",","",$stop_loss);


    //Set Stoploss
    $end_point = "https://api.kite.trade/orders/amo";
    $res = $client->request('POST', $end_point, [
        'form_params' => [
            'tradingsymbol' => $symbol,
            'exchange' => 'NSE',
            'transaction_type' => "SELL",
            'order_type' => 'SL-M',
            'trigger_price' => $stop_loss,
            'quantity' => $quantity,
            'product' => 'CNC',
            'validity' => 'DAY'

        ]
    ]);

    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));

    //Fetching order id
    $order_id = $response['data']['order_id'];
    echo "StopLose Order for $symbol : $order_id";
    echo "\n";


    #reseting the dailyentry
    $id = $value['id'];
    $query = "UPDATE `stockAmo` SET `stop_loss`='$stop_loss' WHERE id = '$id'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);




}


















?>
