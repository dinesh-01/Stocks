<?php


require_once './include/common.php';


 $sid           = $_POST['sid'];
 $sqbuy         = $_POST['qbuy'];
 $sqvolume      = $_POST['qvolume'];
 $sqtotal       = $_POST['qtotal'];
 $stock_signal  = $_POST['stock_signal'];
 $order_type    = $_POST['order_type'];
 $stop_loss     = $_POST['stop_loss'];
 $target        = $_POST['target'];


$field = array('qbuy' => $sqbuy,'qvolume' => $sqvolume, 'qtotal' => $sqtotal,
                'stock_signal' => $stock_signal, 'order_type' => $order_type, 'stop_loss' => $stop_loss,
                'target' => $target);

 $table = "stocklistbackup";
 $condition = "id = $sid";
 $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
 update($arugment);

 $tField = array("sum(qtotal) as totals");
 $condition =  "sEntry = 'old'   and isWatch = 'yes' and priority = 1";
 $tarugment  =  array( "field" => $tField , "table" => $table, "condition" => $condition);
 $tdata      =  select($tarugment,"one");
 echo $tdata["totals"];

?>