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



        if(is_null($order_id) || empty($order_id)) {

           //Fetch Current Price of the index
             $current_price = get_current_price_index($symbol);
             $condition = false;


               if(!empty($support_value)) {
                   $condition = match_condition('support', $support_value , $current_price);
               } else {
                   $condition = match_condition('target', $trigger_value , $current_price);
               }

                if($condition == true) {

                        $order_id = place_order_buy_index($symbol,$quantity,"market");
                        sleep(2);

                        $last_price = order_last_price($order_id);
                        $total_value = ceil($last_price * $quantity);

                        $sell_order_id = place_order_sell_index($symbol,$quantity,$last_price);

                        $percentage_value = STOPLOSS_BOOKING / 100 ;
                        $amount_value = $last_price * $percentage_value;
                        $stoploss_value = round($last_price - $amount_value,1);

                        $query = "UPDATE `optionAmo` SET `order_id`= '$order_id', `sl_order_id` = '$sell_order_id', `total_value` = '$total_value',`track_status` = 'Order Executed', `price` = '$last_price', `stop_loss_value` = '$stoploss_value'  WHERE id = '$id'";
                        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

                        echo "Order Executed for Symbol : $symbol";

                    } else {

                      echo "Order Pending for Symbol : $symbol";
                      echo "\n";
                }




        }

   }


















?>
