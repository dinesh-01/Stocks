<?php

function watch_list_query($type,$priority=1) {

	 $query = "select * from stocklistIntra where isWatch = 'yes' order by order_status";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}


function company_list_query($type) {


    if($type == "nifty") {
       $catagory = "stocklistIntra.sType = '$type'";
    }

    if($type == "N50") {
        $catagory = "stocklistIntra.ntype = 'option'";
    }

    $query = "Select * from stocklistIntra";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}

function company_list_bees_query($type) {

    $query = "SELECT * FROM `stockbeeslist` where `isWatch` = '$type'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    while($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

    return $results;

}

function company_list_future_query($type) {

    $query = "SELECT * FROM `stocklistIntrafutures` where `isWatch` = '$type'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    while($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

    return $results;

}


function company_list_range_query($r1,$r2) {


  $query = "Select stocklistIntra.id as id,stocklistIntra.ntype as ntype,stocklistIntra.cSymbol as cSymbol,stocklistIntra.notes as notes,stocklistIntra.support_value as support_value,stocklistIntra.resistance_value as resistance_value,stocklistIntra.sName as sName,stocklistIntra.murl as murl,stocklistIntra.curl as curl,stockvaluesIntra.open as currOpen,stockvaluesIntra.high as currHigh,stockvaluesIntra.low as currLow,stockvaluesIntra.close as currClose,stockvaluesIntra.schange as pChange,stockvaluesIntra.volume as volume From stocklistIntra INNER JOIN  stockvaluesIntra WHERE stocklistIntra.id = stockvaluesIntra.sid   AND stocklistIntra.isWatch = 'no' AND stockvaluesIntra.id = (SELECT MAX(id) from stockvaluesIntra where sid = stocklistIntra.id) and stockvaluesIntra.low BETWEEN $r1 AND $r2 order by stocklistIntra.cSymbol";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}

function search_single_company_query($string) {

$query = "Select * from  stocklistIntra where stocklistIntra.sName like '%$string%'";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}


function search_single_company_feature_query($string) {

    $query = "select * from stocklistIntrafutures where isWatch='no' and cSymbol like '%$string%'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    while($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

    return $results;

}



function fetch_price_stocks($range1,$range2) {

    //Getting all stocks

    $query  = "Select cSymbol from stocklistIntrabackup where id > $range1 and id < $range2";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
    $row    = mysqli_fetch_all($result);
    $i = 1;

    //Concating all stocks at onces
    foreach ($row as $record) {

        $api_symbol = $record[0];

        if (str_contains($api_symbol, "&")) {
            $api_symbol = str_replace("&", "%26", $api_symbol);
        }


        $all_stocks[] = "i=NSE:" . $api_symbol;

        return $all_stocks;

    }

}



?>
