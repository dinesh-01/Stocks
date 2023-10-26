<?php
require_once './include/common.php';


//url => https://www.nseindia.com/products-services/indices-nifty500-index

$filename = 'data/bees.csv'; // Replace with your file name or path

// Open the CSV file for reading
$file = fopen($filename, 'r');

while (($line = fgetcsv($file)) !== FALSE) {
  $records[] =  $line;
}
fclose($file);

array_shift($records); // Removing header

foreach ($records as $record) {

   $company = $record[0];
   $symbol =  $record[1];
   $stockType = $record[1];


  //$symbol = urlencode($symbol);

  $query  = "Select id from stockbeeslist where Csymbol = '$symbol'";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
  $row    = mysqli_fetch_assoc($result);

  if(empty($row['id'])) {

   $company = mysqli_real_escape_string($GLOBALS['mysqlConnect'],$company);

    $money_control = "https://www.google.com/search?q=".$symbol."+moneycontrol";
    $charink = "https://chartink.com/stocks/$symbol.html";

     echo $query  = "INSERT INTO stockbeeslist(sName, cSymbol, mcurl, murl, curl, tickertape, industry, ntype) VALUES ('$company','$symbol','$money_control','','$charink','','','N500')";
     $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
     sleep(1);

    echo "\n";

  }

}

?>
