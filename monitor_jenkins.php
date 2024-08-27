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
    $iceberg_leg = $value['iceberg_leg'];


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


           if($last_price < $stop_loss_value) {

               $last_price =  symbol_last_price($symbol);
               $percentage_value = 0.1 / 100 ;
               $amount_value = $last_price * $percentage_value;
               $final_amount = round($last_price - $amount_value,1);

               $end_point = "https://api.kite.trade/orders/regular/$sl_order_id";
               $res = $client->request('PUT', $end_point, [
                   'form_params' => [
                       'price' => $final_amount
                   ]
               ]);


               $query = "UPDATE `optionAmo` SET `status`= 'completed', `track_status` = 'SL Triggered' WHERE id = '$id'";
               $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

               echo "SL Triggered :(";

           }


       }else{

           $query = "UPDATE `optionAmo` SET `status`= 'completed', `track_status` = 'Target Triggered' WHERE id = '$id'";
           $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

           echo "Target Triggered :D";
       }


   }

}


















?>
