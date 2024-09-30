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


    $main_symbol = explode("24",$symbol);
    $main_symbol = $main_symbol[0];




        if(is_null($order_id) || empty($order_id)) {


             $condition = false;


               //Support
               if(!empty($support_value)) {
                   $condition = support_match_condition($main_symbol, $support_value);
               }

               //Resistance
                if(!empty($resistance_value)) {
                    $condition = resistance_match_condition($main_symbol, $resistance_value);
                }




                if($condition === true) {

                        $order_id = place_order_buy_index($symbol,$quantity,ORDER_TYPE);

                        $query = "UPDATE `optionAmo` SET `order_id`= '$order_id',  `track_status` = 'Order Placed'  WHERE id = '$id'";
                        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

                        echo "Order Placed for Symbol : $symbol";

                    } else {

                      echo " => Order Pending for Symbol : $symbol";
                      echo "\n";
                }




        }


   }


















?>
