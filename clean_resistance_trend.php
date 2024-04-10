<?php
require_once './include/common.php';

//Fetching stock Symbol
$query  = "UPDATE `stocklist` SET `resistance_signal`='0'";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);


header("location:resistance_monitor.php");
exit;













?>
