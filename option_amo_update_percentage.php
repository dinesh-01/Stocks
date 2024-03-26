<?php

require_once './include/common.php';

$order_id = $_POST['order_id'];
$percentage = $_POST['pri'];

$query = "UPDATE optionAmo SET `book_percentage`='$percentage' where order_id = '$order_id' ";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

?>
