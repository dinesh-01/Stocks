<?php

require_once './include/common.php';

$query  = "SELECT `cSymbol`,`qbuy`,`qvolume`,`stock_signal`,`target`,`stop_loss`,`order_type` FROM `stocklist` WHERE `isWatch` = 'Yes' and `priority` = '1' ";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$id = $result->fetch_all(MYSQLI_ASSOC);


$jon = json_encode($id);
print $jon;


?>
