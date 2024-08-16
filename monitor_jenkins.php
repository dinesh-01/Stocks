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



$field     =  array("id,order_id,sl_order_id,sl,tr,symbol,price,quanity,iceberg_leg,created_date");
$table     =  "optionAmo";
$condition =  "status = 'open'";
$arugment  =  array( "field" => $field , "table" => $table, 'condition' => $condition);
$data      =  select($arugment,"many");



foreach ($data as $value) {


    $id = $value['id'];
    $sl_order_id = $value['sl_order_id'];
    $sl_percent = $value['sl'];
    $tr_percent = $value['tr'];
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

       //Fetching average price
       $status = $response['data'][$length]['status'];

       echo "STOPLOSS STATUS => $status";
       echo "\n";


       if($status != 'COMPLETE') {

           $target_percentage = ($tr_percent/100) ;
           $target_diff =  $price * $target_percentage;
           $target = $price + $target_diff;
           $target =  number_format($target,1);
           $target = str_replace(",","",$target);

           echo "TARGET => $target"; //100
           echo "\n";

           $end_point = "https://api.kite.trade/quote?i=NFO:$symbol";
           $res = $client->request('GET', $end_point);
           $response = $res->getBody()->getContents();
           $response = (json_decode($response, true));
           $last_price = $response['data']["NFO:$symbol"]['last_price'];
           $last_price = str_replace(",", "", $last_price); //last price

           echo "LAST PRICE => $last_price"; //103


           if($target < $last_price) {

               $end_point = "https://api.kite.trade/orders/regular/$sl_order_id";
               $res = $client->request('DELETE',$end_point);

               $end_point = "https://api.kite.trade/orders/regular";


               /*
               $res = $client->request('POST', $end_point, [
                   'form_params' => [
                       'tradingsymbol' => $symbol,
                       'exchange' => 'NFO',
                       'transaction_type' => "SELL",
                       'order_type' => 'MARKET',
                       'quantity' => $quantity,
                       'product' => 'NRML',
                       'validity' => 'DAY'

                   ]
               ]);

               */



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




               $query = "UPDATE `optionAmo` SET `status`= 'completed', `track_status` = 'Target Triggered :D' WHERE id = '$id'";
               $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

               echo "Target Price Triggered :D";

           }


       }else{

           $query = "UPDATE `optionAmo` SET `status`= 'completed', `track_status` = 'SL Triggered :(' WHERE id = '$id'";
           $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

           echo "Stoploss Triggered :(";
       }


   }

}


















?>
