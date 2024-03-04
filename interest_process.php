<?php

require_once './include/common.php';



$amount     = $_POST['amount'];  // 100
$amount_given = $_POST['amount_given']; // 10


$interest = round(( 0.145 * $amount) / 12 ) ;
$principle = round($amount_given - $interest);
$pending_amount = round($amount - $principle);


header("location:interest.php?interest=$interest&pending_amount=$pending_amount&principle=$principle");
exit;

 ?>
