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
    $sl_order_id = $value['sl_order_id'];
    $stop_loss_value = $value['stop_loss_value'];
    $symbol   = $value['symbol'];
    $quantity = $value['quanity'];
    $price    = $value['price'];
    $total_value = $value['total_value'];
    $current_sl = $value['current_sl'];
    $next_sl = $value['next_sl'];


   if($sl_order_id != null || !empty($sl_order_id)) {

       $end_point = "https://api.kite.trade/orders/$sl_order_id";
       $res = $client->request('GET', $end_point);
       $response = $res->getBody()->getContents();
       $response = (json_decode($response,true));

       $length = count($response['data']);
       $length =  $length-1;

       //Fetching Status
       $status = $response['data'][$length]['status'];

       echo "Target status => $status";
       echo "\n";


       if($status != 'COMPLETE') {


           $last_price =  symbol_last_price($symbol);
           echo "LAST PRICE => $last_price"; //103
           echo "\n";


           $price_diff = $last_price - $price;
           $amount_diff = round($price_diff,1) *  $quantity;
           $current_percentage = number_format(($amount_diff / $total_value) * 100,1);


           if($current_percentage >= $next_sl) { // 3 > 2


               if(empty($current_sl) || $current_sl == 0) { $current_sl = -2; }

               $percentage_value = $current_sl / 100 ;
               $amount_value = $last_price * $percentage_value;
               $final_amount = round($last_price - $amount_value,1);

               $end_point = "https://api.kite.trade/orders/regular/$sl_order_id";
               $res = $client->request('PUT', $end_point, [
                   'form_params' => [
                       'trigger_price' => $last_price,
                       'price' => $final_amount
                   ]
               ]);


               if( $current_sl == -2) { $current_sl = 0; }

               $current_sl = $current_sl + SL_INCREMENT;
               $next_sl = $next_sl + SL_INCREMENT;


               $query = "UPDATE `optionAmo` SET `current_sl` = '$current_sl', `next_sl` = '$next_sl', `track_status` = 'SL Updated' WHERE id = '$id'";
               $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

               echo "SL Updated";

           }


       } else {

           $query = "UPDATE `optionAmo` SET `status`= 'completed', `track_status` = 'SL Triggered' WHERE id = '$id'";
           $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

           echo "SL Triggered";
       }


   }

}


















?>
