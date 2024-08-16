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
    $symbol   = $value['symbol'];
    $quantity = $value['quanity'];
    $trigger_value = $value['trigger_value'];


   if(is_null($order_id) || empty($order_id)) {

       //Fetch Current Price of the index
        $current_price = get_current_price_index($symbol);

       if($trigger_value >= $current_price) {

           $order_id = place_order_index($symbol,$quantity,"market");
           $query = "UPDATE `optionAmo` SET `order_id`= '$order_id',`track_status` = 'Order Executed' WHERE id = '$id'";
           $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

       }

       echo 'Order Executed';

   }

}


















?>
