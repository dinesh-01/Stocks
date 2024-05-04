<?php

require_once './include/common.php';

$id   = $_POST['id'];
$support = $_POST['support_value'];
$resistance = $_POST['resistance_value'];

$field     = array('support_value' => $support,'resistance_value' => $resistance);
$table     = "stocklistIntra";
$condition = "id = $id";
$arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
update($arugment);

?>
