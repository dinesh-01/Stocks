<?php

require_once './include/common.php';



$id   = $_POST['id'];
$symbol = $_POST['symbol'];
$price = $_POST['price'];
$quanity = $_POST['quanity'];

$date = date('d-m-Y');


$field = array('price' => $price,'quanity' => $quanity);
$table = "stockAmoIntra";
$condition = "id = $id";
$arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
update($arugment);

header("location:stock_execution.php");
exit;

 ?>
