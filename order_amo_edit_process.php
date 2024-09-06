<?php

require_once './include/common.php';



$id   = $_POST['id'];
$trigger_value = $_POST['trigger_value'];
$support_value = $_POST['support_value'];

$price = $_POST['price'];

$date = date('d-m-Y');


$field = array('trigger_value'=> $trigger_value,'support_value'=> $support_value,'price'=>$price);
$table = "optionAmo";
$condition = "id = $id";
$arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
update($arugment);

header("location:order_amo_edit.php?id=$id");
exit;

 ?>
