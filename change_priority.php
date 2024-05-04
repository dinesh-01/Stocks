<?php

require_once './include/common.php';

 $no   = $_POST['pri'];
 $id   = $_POST['id'];

$field     = array('priority' => $no);
$table     = "stocklistIntra";
$condition = "id = $id";
$arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
 update($arugment);



 ?>
