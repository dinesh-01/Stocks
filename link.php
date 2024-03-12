<?php

//including common files
require_once './include/common.php';

//Checking stock already exists in table
$query = "SELECT * FROM `stocklist` where `isWatch` = 'no' order by cSymbol";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

while($row = mysqli_fetch_assoc($result)) {
    $td =  $row['cSymbol'];

    if($row['qbuy'] > 0) {
        echo "https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A".$td."1%21";
        echo "<br/>";
    }

}





?>