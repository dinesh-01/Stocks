<?php
require_once './include/common.php';


//url => https://www.nseindia.com/products-services/indices-nifty500-index



$filename = 'data/nifty.csv'; // Replace with your file name or path
$date = date('d-m-Y');

// Open the CSV file for reading
$file = fopen($filename, 'r');

if ($file) {
// Read the header row
  $header = fgetcsv($file);


// Read and output the remaining rows
  while (($row = fgetcsv($file)) !== false) {

    $csymbol = $row[0];
    echo $query = "UPDATE $stockListTable SET ntype='N50'  where Csymbol = '$csymbol'";
    $result = mysqli_query($GLOBALS['mysqlConnect'], $query);
    $query = mysqli_fetch_assoc($result);
    echo "\n";

  }

}

?>
