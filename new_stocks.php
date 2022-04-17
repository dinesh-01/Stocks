<?php
require_once './include/common.php';

$file = fopen('data/MW-NIFTY-200-17-Apr-2022.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
  $records[] =  $line;
}
fclose($file);

array_shift($records); // Removing header

foreach ($records as $record) {


  /* [0] => SYMBOL */

  $symbol =  $record[0];
  $symbol = urlencode($symbol);


  $query  = "Select id from stocklist where Csymbol = '$symbol'";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
  $row    = mysqli_fetch_assoc($result);

  if(empty($row['id'])) {

    echo urldecode($symbol);

    $money_control = "https://www.google.com/search?q=".$symbol."+moneycontrol";
    $charink = "https://chartink.com/stocks/$symbol.html";

     $query  = "INSERT INTO stocklist(sName, cSymbol, murl, curl, ntype) VALUES ('$symbol','$symbol','$money_control','$charink','N200')";
     $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    echo "\n";

  }

}

?>
