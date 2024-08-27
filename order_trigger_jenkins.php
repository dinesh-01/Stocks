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



        if(is_null($order_id) || empty($order_id)) {

           //Fetch Current Price of the index
             $current_price = get_current_price_index($symbol);


                if($trigger_value <= $current_price) {

                        $order_id = place_order_buy_index($symbol,$quantity,"market");
                        sleep(2);

                        $last_price = order_last_price($order_id);
                        $total_value = ceil($last_price * $quantity);

                        $sell_order_id = place_order_sell_index($symbol,$quantity,$last_price);

                    }


                    $query = "UPDATE `optionAmo` SET `order_id`= '$order_id', `sl_order_id` = '$sell_order_id', `total_value` = '$total_value',`track_status` = 'Order Executed', `price` = '$last_price'  WHERE id = '$id'";
                    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

                    echo 'Order Executed';

        }

   }


















?>
