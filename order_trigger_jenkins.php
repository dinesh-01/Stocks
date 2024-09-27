<?php
require_once './include/common.php';


$field     =  array("*");
$table     =  "optionAmo";
$condition =  "status = 'open'";
$arugment  =  array( "field" => $field , "table" => $table, 'condition' => $condition);
$data      =  select($arugment,"many");
$iceberg_status = 'no';

 foreach ($data as $value) {

    $id = $value['id'];
    $order_id = $value['order_id'];
    $symbol   = $value['symbol'];
    $quantity = $value['quanity'];
    $trigger_value = $value['trigger_value'];
    $support_value = $value['support_value'];
    $resistance_value = $value['resistance_value'];



        if(is_null($order_id) || empty($order_id)) {

           //Fetch Current Price of the index
             $current_price = symbol_last_price($symbol);
             $condition = false;


               //Support
               if(!empty($support_value)) {
                   $condition = support_match_condition($symbol, $support_value);
               }

               //Resistance
               elseif(!empty($resistance_value)) {
                   $condition = resistance_match_condition($symbol, $resistance_value);
               }

               //CandleStick
               else {
                   $condition = match_condition( $trigger_value , $current_price);
               }


                if($condition === true) {

                        $order_id = place_order_buy_index($symbol,$quantity,ORDER_TYPE);

                       // $sell_order_id = place_order_sell_index($symbol,$quantity,$last_price);
                      //  $sell_order_id = place_stop_loss_index($symbol,$quantity,$last_price);

                        $query = "UPDATE `optionAmo` SET `order_id`= '$order_id',  `track_status` = 'Order Placed'  WHERE id = '$id'";
                        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

                        echo "Order Placed for Symbol : $symbol";

                    } else {

                      echo "Order Pending for Symbol : $symbol";
                      echo "\n";
                }




        }

   }


















?>
