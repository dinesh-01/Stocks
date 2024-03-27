<?php

require_once './include/common.php';

$id   = $_POST['id'];
$support = $_POST['support_value'];

$field     = array('support_value' => $support);
$table     = "stocklist";
$condition = "id = $id";
$arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
update($arugment);

?>
