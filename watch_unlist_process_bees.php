<?php

require_once './include/common.php';

$id   = $_POST['id'];

$field     = array('isWatch' => 'no');
$table     = "stockbeeslist";
$condition = "id = $id";
$arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
update($arugment);

 ?>
