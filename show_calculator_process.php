<?php


require_once './include/common.php';


 $sid      = $_POST['sid'];
 $sqbuy    = $_POST['qbuy'];
 $sqvolume = $_POST['qvolume'];
 $sqtotal  = $_POST['qtotal'];

 $field = array('qbuy' => $sqbuy,'qvolume' => $sqvolume, 'qtotal' => $sqtotal );
 $table = "stocklist";
 $condition = "id = $sid";
 $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
 update($arugment);

 $tField = array("sum(qtotal) as totals");
 $condition =  "sEntry = 'old'   and isWatch = 'yes' and priority = 1";
 $tarugment  =  array( "field" => $tField , "table" => $table, "condition" => $condition);
 $tdata      =  select($tarugment,"one");
 echo $tdata["totals"];

?>