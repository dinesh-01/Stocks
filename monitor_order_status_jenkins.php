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



$field     =  array("*");
$table     =  "optionAmo";
$condition =  "status = 'open'";
$arugment  =  array( "field" => $field , "table" => $table, 'condition' => $condition);
$data      =  select($arugment,"many");



foreach ($data as $value) {



    $id = $value['id'];
    $order_id = $value['order_id'];
    $sl_order_id = $value['sl_order_id'];
    $stop_loss_value = $value['stop_loss_value'];
    $symbol   = $value['symbol'];
    $quantity = $value['quanity'];
    $price    = $value['price'];
    $total_value = $value['total_value'];
    $current_sl = $value['current_sl'];
    $next_sl = $value['next_sl'];


    if($order_id != null || !empty($order_id)) {

        if($sl_order_id == null || empty($sl_order_id)) {

               $end_point = "https://api.kite.trade/orders/$order_id";
               $res = $client->request('GET', $end_point);
               $response = $res->getBody()->getContents();
               $response = (json_decode($response,true));

               $length = count($response['data']);
               $length =  $length-1;

               //Fetching Status
               $status = $response['data'][$length]['status'];

               echo "Order status => $status";
               echo "\n";


               if($status === 'COMPLETE') {

                   $last_price = order_last_price($order_id);
                   $total_value = ceil($last_price * $quantity);


                   // $sell_order_id = place_stop_loss_index_sample($symbol,$quantity,$stop_loss_value);
                   $sell_order_id = place_stop_loss_index($symbol, $quantity, $last_price);

                   $stop_loss_percentage = (STOPLOSS_BOOKING / 100);
                   $stop_loss_diff = $last_price * $stop_loss_percentage;
                   $stop_loss = $last_price - $stop_loss_diff;
                   $stop_loss = number_format($stop_loss, 1);
                   $stop_loss = str_replace(",", "", $stop_loss);


                   $query = "UPDATE `optionAmo` SET  `sl_order_id` = '$sell_order_id',`total_value` = '$total_value', `stop_loss_value` = '$stop_loss', `price` = '$last_price',  `track_status` = 'SL Placed'  WHERE id = '$id'";
                   $result = mysqli_query($GLOBALS['mysqlConnect'], $query);

                   echo "SL Placed => $status";
                   echo "\n";
                   echo "************";
                   echo "\n";
               }

       }
   }

}




















?>
