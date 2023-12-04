<?php
require_once './include/common.php';



    #fetch order details
    $last_price = 90.50;

    $target_percentage = (1/100) ;
    $target_diff =  $last_price * $target_percentage;
    $target = $last_price + $target_diff;
    $target =  number_format($target,1);
    $target = str_replace(",","",$target);

    echo $target




















?>
