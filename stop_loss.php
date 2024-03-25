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
$table     =  "optionAmo";
$condition =  "status = 'open'";
$arugment  =  array( "field" => $field , "table" => $table, 'condition' => $condition);
$data      =  select($arugment,"many");


foreach ($data as $value) {

    $last_price = $value['price'];
    $symbol     = $value['symbol'];
    $quantity   = $value['quanity'];


    $stop_loss_trigger_percentage = (9/100) ;
    $stop_loss_diff =  $last_price * $stop_loss_trigger_percentage;
    $stop_loss_trigger = $last_price - $stop_loss_diff;
    $stop_loss_trigger = number_format($stop_loss_trigger ,1);
    $stop_loss_trigger = str_replace(",","",$stop_loss_trigger);

    $stop_loss_percentage = (10/100) ;
    $stop_loss_diff =  $last_price * $stop_loss_percentage;
    $stop_loss = $last_price - $stop_loss_diff;
    $stop_loss = number_format($stop_loss ,1);
    $stop_loss = str_replace(",","",$stop_loss);


    //Set Stoploss
    $end_point = "https://api.kite.trade/orders/regular";
    $res = $client->request('POST', $end_point, [
        'form_params' => [
            'tradingsymbol' => $symbol,
            'exchange' => 'NFO',
            'transaction_type' => "SELL",
            'order_type' => 'SL',
            'price' => $stop_loss,
            'trigger_price' => $stop_loss_trigger,
            'quantity' => $quantity,
            'product' => 'NRML',
            'validity' => 'DAY'

        ]
    ]);

    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));

    //Fetching order id
    $order_id = $response['data']['order_id'];
    echo "StopLose Order for $symbol : $stop_loss";
    echo "\n";


    #reseting the dailyentry
    $id = $value['id'];
    $query = "UPDATE `optionAmo` SET `order_id`='$order_id', `price`='$last_price',`stop_loss`='$stop_loss', `status`= 'completed' WHERE id = '$id'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);




}


















?>
