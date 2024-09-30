<?php
require_once './include/common.php';


if ( (time() > strtotime("09:15:00")) &&  (time() < strtotime("15:30:00"))  ) {
    $order_decide_type = "regular";
    $per = "5%";
}else{
    $order_decide_type = "amo";
    $per = "7%";
}



// setting up end headers
    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);

$field     =  array("*");
$table     =  "optionAmo";
$condition =  "status = 'open'";
$arugment  =  array( "field" => $field , "table" => $table, 'condition' => $condition);
$data      =  select($arugment,"many");



foreach ($data as $value) {



    #fetch order details
    $id = $value['id'];
    $order_id = $value['order_id'];
    $sl_order_id = $value['sl_order_id'];
    $symbol   = $value['symbol'];
    $quantity = $value['quanity'];
    $last_price = $value['price'];
    $sl_percent = $value['sl'];
    $exit_time = $value['exit_time'];
    $current_time = date("H:i");

    echo "Current Time => $current_time";
    echo "\n";
    echo  "Exit Time => $exit_time";
    echo "\n";
    echo "********";
    echo "\n";


    if(!empty($sl_order_id) || !is_null($sl_order_id)) {


        if ($current_time >= $exit_time) {

            $last_price = symbol_last_price($symbol); //last price
            $percentage_value = 0.1 / 100 ;
            $amount_value = $last_price * $percentage_value;
            $final_amount = round($last_price - $amount_value,1);

            $end_point = "https://api.kite.trade/orders/regular/$sl_order_id";
            $res = $client->request('PUT', $end_point, [
                'form_params' => [
                    'price' => $final_amount
                ]
            ]);


            $query = "UPDATE `optionAmo` SET `track_status` = 'Time Triggered', `status` = 'completed' WHERE id = '$id'";
            $result = mysqli_query($GLOBALS['mysqlConnect'], $query);

            echo "Time Triggered";

        }
    }



}


















?>
