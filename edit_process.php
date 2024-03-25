<?php

require_once './include/common.php';



$id   = $_POST['id'];
$stock_name = $_POST['stock_name'];
$curl = $_POST['curl'];
$murl = $_POST['murl'];

$notes = mysqli_real_escape_string($GLOBALS['mysqlConnect'],$_POST['notes']);
$date = date('d-m-Y');


$field = array('curl' => $curl,'murl' => $murl, 'grow' => $notes );
$table = "stocklist";
$condition = "id = $id";
$arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
update($arugment);

if(!empty(basename($_FILES["fileToUpload"]["name"]))) {

 $target_dir = "uploads/";
 $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
 move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

 $query  = "INSERT INTO stockTrend(sid, stock_name, chart_ink, trend_file_date, notes, createdDate) VALUES ('$id', '$stock_name', '$curl', '$target_file', '$notes','$date')";
 $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

} else {

 $query  = "INSERT INTO stockTrend(sid, stock_name, chart_ink, trend_file_date, notes, createdDate) VALUES ('$id', '$stock_name', '$curl', 'no_image', '$notes','$date')";
 $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

}

header("location:list_watch.php?msg=File updated successfully&id=".$id);
exit;

 ?>
