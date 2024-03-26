<?php

//including common files
require_once './include/common.php';


//Evaluating content
$sname         = $_POST['stocks'];
$option_symbol = $_POST['option_symbol'];
$price         = $_POST['option_to_buy'];


$field       =  array("symbol"=>$sname,"price"=>$price,"option_symbol"=>$option_symbol);
insert($field , "optionTrigger"); //Adding in record
      
 header("location:option_trigger.php?msg=$option_symbol added successfully");
 exit;

?>
