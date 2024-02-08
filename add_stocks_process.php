<?php

//including common files
require_once './include/common.php';


//Evaluating content
$sname       = $_POST['stock_name'];
$murl        = $_POST['murl'];
$curl        = $_POST['curl'];
$type        = $_POST['type'];
$notes       = $_POST['notes'];
$companyinfo = $_POST['company_info'];

$field       =  array("sName"=>$sname,"cSymbol"=>$companyinfo,"murl"=>$murl,"curl"=>$curl,"notes"=>$notes,"sType"=>$type);
insert($field , "$stockListTable"); //Adding in record
      
 header("location:add_stocks.php?msg=$sname added successfully");
 exit;

?>
