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
$arugment  =  array( "field" => $field , "table" => $table);
$data      =  select($arugment,"many");


foreach ($data as $value) {

    #fetch order details
    $order_id = $value['order_id'];
    $symbol   = $value['symbol'];
    $quantity = $value['quanity'];
    $last_price = $value['price'];

    $target_percentage = (3/100) ;
    $target_diff =  $last_price * $target_percentage;
    $target = $last_price + $target_diff;
    $target =  number_format($target,1);
    $target = str_replace(",","",$target);

    //Set target
    $end_point = "https://api.kite.trade/orders/amo";
    $res = $client->request('POST', $end_point, [
        'form_params' => [
            'tradingsymbol' => $symbol,
            'exchange' => 'NFO',
            'transaction_type' => "SELL",
            'order_type' => 'LIMIT',
            'price' => $target,
            'quantity' => $quantity,
            'product' => 'NRML',
            'validity' => 'DAY'

        ]
    ]);

    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));

    //Fetching order id
    $order_id = $response['data']['order_id'];
    echo "Target for $symbol : $target";
    echo "\n";



    #reseting the dailyentry
    $id = $value['id'];
    $query = "UPDATE `optionAmo` SET `price`='$last_price',`target`='$target' WHERE id = '$id'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);




}


















?>
