<?php

require_once './include/common.php';



$amount     = $_POST['amount'];  // 100
$percentage = $_POST['percentage']; // 10

$target_percentage_value = $percentage / 100 ;
$amount_value = $amount * $target_percentage_value;
$taget = $amount + $amount_value;


$stop_loss_percentage_value = $percentage / 100 ;
$amount_value = $amount * $stop_loss_percentage_value;
$stop_loss = $amount - $amount_value;


$taget = round($taget, 1);
$stop_loss = round($stop_loss, 1);


header("location:calculator.php?target=$taget&stop=$stop_loss");
exit;

 ?>
