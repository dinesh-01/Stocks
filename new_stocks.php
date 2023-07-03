<?php
require_once './include/common.php';


//url => https://www.nseindia.com/products-services/indices-nifty500-index

$file = fopen('data/500_01.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
  $records[] =  $line;
}
fclose($file);

array_shift($records); // Removing header

foreach ($records as $record) {

   $company = $record[0];
   $symbol =  $record[2];
   $stockType = $record[1];


  //$symbol = urlencode($symbol);

  $query  = "Select id from stocklist where Csymbol = '$symbol'";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
  $row    = mysqli_fetch_assoc($result);

  if(empty($row['id'])) {

   $company = mysqli_real_escape_string($GLOBALS['mysqlConnect'],$company);

    $money_control = "https://www.google.com/search?q=".$symbol."+moneycontrol";
    $charink = "https://chartink.com/stocks/$symbol.html";

     $query  = "INSERT INTO stocklist(sName, cSymbol, murl, curl, tickertape, industry, ntype) VALUES ('$company','$symbol','$money_control','$charink','','$stockType','N500')";
     $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    echo "\n";

  }

}

?>
