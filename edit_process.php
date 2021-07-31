<?php

require_once './include/common.php';

$id   = $_POST['id'];
$curl = $_POST['curl'];
$murl = $_POST['murl'];
$notes = mysqli_escape_string($_POST['notes']);


$field = array('curl' => $curl,'murl' => $murl, 'notes' => $notes );
$table = "stocklist";
$condition = "id = $id";
$arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
update($arugment);

header("location:list_watch.php?msg=$name updated successfully&id=".$id);
exit;

 ?>
