<?php
require_once './include/common.php';


//url => https://www.nseindia.com/products-services/indices-nifty500-index

$filename = 'data/all_stocks.csv'; // Replace with your file name or path

// Open the CSV file for reading
$file = fopen($filename, 'r');

while (($line = fgetcsv($file)) !== FALSE) {
  $records[] =  $line;
}
fclose($file);

array_shift($records); // Removing header

foreach ($records as $record) {

   $company = $record[2];
   $symbol =  $record[1];
   $stockType = $record[1];


  //$symbol = urlencode($symbol);

  $query  = "Select id from stocklistIntrabackup where Csymbol = '$symbol'";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
  $row    = mysqli_fetch_assoc($result);

  if(empty($row['id'])) {

    $money_control = "https://www.google.com/search?q=".$company."+moneycontrol";
    $charink = "https://chartink.com/stocks/$symbol.html";

     echo $query  = "INSERT INTO stocklistIntrabackup(sName, cSymbol, mcurl, murl, curl, tickertape, industry, ntype) VALUES ('$company','$symbol','$money_control','','$charink','','','equity')";
     $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


    echo "\n";

  }

}

?>
