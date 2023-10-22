<?php
require_once './include/common.php';

    $url    = $_GET['trading_view_url'];
    $price  = $_GET['price'];
    $option = $_GET['option'];


    $split_array = explode(":",$url);
    $symbol = $split_array[2];



    $query  = "UPDATE stocklist SET stock_signal = '$option', qbuy = '$price'  WHERE cSymbol = '$symbol' ";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


    echo $symbol." => ".$price." => ".$option;


?>
