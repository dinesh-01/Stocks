<?php

require_once './include/common.php';

$id   = $_POST['id'];

$field     = array('isWatch' => 'yes');
$table     = "$stockListTablefutures";
$condition = "id = $id";
$order     =  "volume desc";
$arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
update($arugment);

 ?>
