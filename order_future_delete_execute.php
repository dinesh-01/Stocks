<?php
require_once './include/common.php';




//Fetching stock Symbol
$order_id = $_GET['id'];



$query = "DELETE from futureAmo where order_id='$order_id'";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);




header("location:stock_futures_execution.php");
exit;













?>
