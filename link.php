<?php

//including common files
require_once './include/common.php';

$t = $_GET['t'];

//Checking stock already exists in table
$query = "SELECT * FROM `stocklistIntra` where `isWatch` = 'no' order by cSymbol";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

while($row = mysqli_fetch_assoc($result)) {
    $link =  $row['curl'];
    echo $link;
    echo "<br/>";






}





?>