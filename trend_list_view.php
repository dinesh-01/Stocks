
<?php

//including common files
require_once './template/header.php';
require_once './include/common.php';


//Watchlist stocks in share calculator
    $sid      =    $_GET['sid'];
    $field     =  array("stock_name,chart_ink,trend_file_date,notes,createdDate");
    $table     =  "stockTrend";
    $order     =  "createdDate";
    $condition =  "sid = '$sid'";
    $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition,"order" => $order);
    $data      =  select($arugment,"many");



   //Rending to tbl file 
    $smarty->assign("datas",$data);
    $smarty->display("trend_list_view.tpl");

?>

