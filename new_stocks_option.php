<?php
require_once './include/common.php';

$query = "SELECT DISTINCT name FROM stockOption";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$records = mysqli_fetch_all($result);


foreach ($records as $record) {

   $company = $record[0];



  //$symbol = urlencode($symbol);



     echo $query = "UPDATE `stocklistbackup` SET `ntype`='option' WHERE `cSymbol` = '$company'";
     $result = mysqli_query($GLOBALS['mysqlConnect'],$query);



  /*
    $company = mysqli_real_escape_string($GLOBALS['mysqlConnect'],$company);

    $money_control = "https://www.google.com/search?q=".$company."+moneycontrol";
    $charink = "https://chartink.com/stocks/$company.html";

     echo $query  = "INSERT INTO stocklistbackup(sName, cSymbol, mcurl, murl, curl, tickertape, industry, ntype) VALUES ('$company','$company','$money_control','','$charink','','','option')";
     $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
     sleep(1);

  */
    echo "\n";





}

?>
