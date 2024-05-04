<?php

require_once './include/common.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $id   = $_POST['id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
 $id   = $_GET['id'];
}


$field     = array('isWatch' => 'yes', 'priority' => 1);
$table     = "stocklistIntra";
$condition = "id = $id";
$order     =  "volume desc";
$arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
update($arugment);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
 header("location:support_monitor.php");
 exit;
}


 ?>
