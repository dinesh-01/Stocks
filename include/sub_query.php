<?php

function watch_list_query($type,$priority=1) {

	 $query = "Select stocklistbackup.id as id,stocklistbackup.ntype as ntype,stocklistbackup.notes as notes,stocklistbackup.cSymbol as cSymbol,stocklistbackup.support_value as support_value,stocklistbackup.resistance_value as resistance_value,
               stocklistbackup.sName as sName,stocklistbackup.murl as murl,stocklistbackup.grow as grow,stocklistbackup.order_status as order_status,stocklistbackup.curl as curl,stocklistbackup.tickertape as ttape,
               stocklistbackup.priority as priority,stockvaluesbackup.open as currOpen,stockvaluesbackup.high as currHigh,
               stockvaluesbackup.low as currLow,stockvaluesbackup.close as currClose,stockvaluesbackup.schange as pChange,
               stockvaluesbackup.volume as volume From stocklistbackup INNER JOIN  stockvaluesbackup 
               WHERE stocklistbackup.id = stockvaluesbackup.sid AND stocklistbackup.isWatch = 'yes' AND stocklistbackup.priority = '$priority'  AND stocklistbackup.sType = '$type' AND stockvaluesbackup.id = (SELECT MAX(id) from stockvaluesbackup 
               where sid = stocklistbackup.id) order by stocklistbackup.sName asc";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}


function company_list_query($type) {


    if($type == "nifty") {
       $catagory = "stocklistbackup.sType = '$type'";
    }

    if($type == "N50") {
        $catagory = "stocklistbackup.ntype = '$type'";
    }

    $query = "Select stocklistbackup.id as id,stocklistbackup.ntype as ntype,stocklistbackup.cSymbol as cSymbol,stocklistbackup.notes as notes,stocklistbackup.sName as sName,
               stocklistbackup.murl as murl,stocklistbackup.curl as curl,stockvaluesbackup.open as currOpen,
               stockvaluesbackup.high as currHigh,stockvaluesbackup.low as currLow,stockvaluesbackup.close as currClose,
               stockvaluesbackup.schange as pChange,stockvaluesbackup.volume as volume From stocklistbackup 
               INNER JOIN  stockvaluesbackup WHERE stocklistbackup.id = stockvaluesbackup.sid AND $catagory  AND stocklistbackup.isWatch = 'no' order by stockvaluesbackup.id DESC LIMIT 0,50";
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

    $query = "SELECT * FROM `stocklistbackupfutures` where `isWatch` = '$type'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    while($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

    return $results;

}


function company_list_range_query($r1,$r2) {


  $query = "Select stocklistbackup.id as id,stocklistbackup.ntype as ntype,stocklistbackup.cSymbol as cSymbol,stocklistbackup.notes as notes,stocklistbackup.support_value as support_value,stocklistbackup.resistance_value as resistance_value,stocklistbackup.sName as sName,stocklistbackup.murl as murl,stocklistbackup.curl as curl,stockvaluesbackup.open as currOpen,stockvaluesbackup.high as currHigh,stockvaluesbackup.low as currLow,stockvaluesbackup.close as currClose,stockvaluesbackup.schange as pChange,stockvaluesbackup.volume as volume From stocklistbackup INNER JOIN  stockvaluesbackup WHERE stocklistbackup.id = stockvaluesbackup.sid   AND stocklistbackup.isWatch = 'no' AND stockvaluesbackup.id = (SELECT MAX(id) from stockvaluesbackup where sid = stocklistbackup.id) and stockvaluesbackup.low BETWEEN $r1 AND $r2 order by stocklistbackup.cSymbol";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}

function search_single_company_query($string) {

$query = "Select stocklistbackup.id as id,stocklistbackup.ntype as ntype,stocklistbackup.notes as notes,stocklistbackup.cSymbol as cSymbol,stocklistbackup.sName as sName,stocklistbackup.murl as murl,stocklistbackup.curl as curl,stockvaluesbackup.open as currOpen,stockvaluesbackup.high as currHigh,stockvaluesbackup.low as currLow,stockvaluesbackup.close as currClose,stockvaluesbackup.schange as pChange,stockvaluesbackup.volume as volume From stocklistbackup INNER JOIN  stockvaluesbackup WHERE stocklistbackup.id = stockvaluesbackup.sid   AND stocklistbackup.isWatch = 'no' AND stockvaluesbackup.id = (SELECT MAX(id) from stockvaluesbackup where sid = stocklistbackup.id) AND  stocklistbackup.sName like '%$string%'order by stockvaluesbackup.volume desc";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}


function search_single_company_feature_query($string) {

    $query = "select * from stocklistbackupfutures where isWatch='no' and cSymbol like '%$string%'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    while($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

    return $results;

}



function fetch_price_stocks($range1,$range2) {

    //Getting all stocks

    $query  = "Select cSymbol from stocklistbackupbackup where id > $range1 and id < $range2";
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
