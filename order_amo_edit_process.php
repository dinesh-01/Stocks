<?php

require_once './include/common.php';



$id   = $_POST['id'];
$tr = $_POST['tr'];
$sl = $_POST['sl'];
$trigger_value = $_POST['trigger_value'];

$date = date('d-m-Y');


$field = array('tr' => $tr,'sl' => $sl,'trigger_value'=> $trigger_value);
$table = "optionAmo";
$condition = "id = $id";
$arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
update($arugment);

header("location:order_amo_edit.php?id=$id");
exit;

 ?>
