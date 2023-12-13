<?php
require_once './include/common.php';


//url => https://www.nseindia.com/products-services/indices-nifty500-index

$file = fopen('data/nifty.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
  $records[] =  $line;
}
fclose($file);

array_shift($records); // Removing header

foreach ($records as $record) {

    $symbol =  $record[0];
    echo  $query  = "UPDATE stocklistbackup SET ntype = 'N50' WHERE cSymbol = '$symbol';";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    echo "\n";



}

?>
