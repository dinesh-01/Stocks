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
          $iceberg_split = $quantity / ICEBERG_SPLIT_QUANTITY; // 4375




            if($trigger_value <= $current_price) {

                if($iceberg_split > 0) {

                     $iceberg_split_deep = explode('.',$iceberg_split);
                     $iceberg_split_deep_first_slice = $iceberg_split_deep[0]; //4
                     $final_iceberg_quanity = $iceberg_split_deep[0] + 1;
                     $order_id = place_order_buy_index_iceberg($symbol,$quantity,$final_iceberg_quanity,"limit");
                     $iceberg_status = 'yes';

                } else {

                    $order_id = place_order_buy_index($symbol,$quantity,"limit");

                }

                sleep(5);

                $last_price = order_last_price($order_id);
                $total_value = ceil($last_price * $quantity);


                //Place sell order
                if($iceberg_split > 1) {

                    $iceberg_split_deep = explode($iceberg_split,'.');
                    $iceberg_split_deep_first_slice = $iceberg_split_deep[0]; //4
                    $final_iceberg_quanity = $iceberg_split_deep[0] + 1;
                    $sell_order_id = place_order_sell_index_iceberg($symbol,$quantity,$final_iceberg_quanity);

                } else {

                    $sell_order_id = place_order_sell_index($symbol,$quantity,$last_price);

                }


                $query = "UPDATE `optionAmo` SET `order_id`= '$order_id', `sl_order_id` = '$sell_order_id', `total_value` = '$total_value',`track_status` = 'Order Executed', `price` = '$last_price', `iceberg_status` = '$iceberg_status'  WHERE id = '$id'";
                $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

                echo 'Order Executed';

            }





   }


}


















?>
