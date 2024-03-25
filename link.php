<?php

//including common files
require_once './include/common.php';

$t = $_GET['t'];

//Checking stock already exists in table
$query = "SELECT * FROM `stocklist` where `isWatch` = 'no' order by cSymbol";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

while($row = mysqli_fetch_assoc($result)) {
    $td =  $row['cSymbol'];

    if (str_contains($td, '&')) {
        $td = str_replace('&','_',$td);
        $td = str_replace('-','_',$td);
    }


  if($t == 'profit') {

      if($row['qbuy'] > 0) {
          echo "https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A".$td;
          echo "<br/>";
      }

  }

    if($t == 'loss') {

        if($row['qbuy'] < 0) {
            echo "https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A".$td;
            echo "<br/>";
        }

    }


}





?>