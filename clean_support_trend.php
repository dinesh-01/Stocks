<?php
require_once './include/common.php';

//Fetching stock Symbol
$query  = "UPDATE `stocklist` SET `support_signal`='0'";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);


header("location:support_monitor.php");
exit;













?>
