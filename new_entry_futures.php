<?php
require_once './include/common.php';


//url => https://www.nseindia.com/products-services/indices-nifty500-index

$filename = 'data/futures.csv'; // Replace with your file name or path

// Open the CSV file for reading
$file = fopen($filename, 'r');

while (($line = fgetcsv($file)) !== FALSE) {
  $records[] =  $line;
}
fclose($file);

array_shift($records); // Removing header

foreach ($records as $record) {

   $symbol  = $record[2];
   $sname   = $record[3];
   $expiry  = $record[5];
   $lot_size = $record[8];

  echo $query  = "INSERT INTO stocklistfutures(sName, cSymbol, expiry, lot_size) VALUES ('$sname','$symbol','$expiry','$lot_size')";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
  echo "\n";
  sleep(1);



}

?>
