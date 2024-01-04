<?php

require_once './include/common.php';



$amount     = $_POST['amount'];  // 100
$percentage = $_POST['percentage']; // 10
$option     = $_POST['option'];

$percentage_value = $percentage / 100 ;
$amount_value = $amount * $percentage_value;

if($option == "call") {
 $final_amount = $amount + $amount_value;
}

if($option == "put") {
 $final_amount = $amount - $amount_value;
}

$final_amount = round($final_amount, 1);

header("location:calculator.php?amount=".$final_amount);
exit;

 ?>
