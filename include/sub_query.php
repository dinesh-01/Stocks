<?php

function watch_list_query($type,$priority=1) {

	 $query = "Select stocklist.id as id,stocklist.ntype as ntype,stocklist.notes as notes,stocklist.cSymbol as cSymbol,stocklist.support_value as support_value,
               stocklist.sName as sName,stocklist.murl as murl,stocklist.grow as grow,stocklist.order_status as order_status,stocklist.curl as curl,stocklist.tickertape as ttape,
               stocklist.priority as priority,stockvalues.open as currOpen,stockvalues.high as currHigh,
               stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,
               stockvalues.volume as volume From stocklist INNER JOIN  stockvalues 
               WHERE stocklist.id = stockvalues.sid AND stocklist.isWatch = 'yes' AND stocklist.priority = '$priority'  AND stocklist.sType = '$type' AND stockvalues.id = (SELECT MAX(id) from stockvalues 
               where sid = stocklist.id) order by stocklist.sName asc";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}


function company_list_query($type) {


    if($type == "nifty") {
       $catagory = "stocklist.sType = '$type'";
    }

    if($type == "N50") {
        $catagory = "stocklist.ntype = '$type'";
    }

    $query = "Select stocklist.id as id,stocklist.ntype as ntype,stocklist.cSymbol as cSymbol,stocklist.notes as notes,stocklist.sName as sName,
               stocklist.murl as murl,stocklist.curl as curl,stockvalues.open as currOpen,
               stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,
               stockvalues.schange as pChange,stockvalues.volume as volume From stocklist 
               INNER JOIN  stockvalues WHERE stocklist.id = stockvalues.sid AND $catagory  AND stocklist.isWatch = 'no' order by stockvalues.id DESC LIMIT 0,50";
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

    $query = "SELECT * FROM `stocklistfutures` where `isWatch` = '$type'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    while($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

    return $results;

}


function company_list_range_query($r1,$r2) {


  $query = "Select stocklist.id as id,stocklist.ntype as ntype,stocklist.cSymbol as cSymbol,stocklist.notes as notes,stocklist.support_value as support_value,stocklist.sName as sName,stocklist.murl as murl,stocklist.curl as curl,stockvalues.open as currOpen,stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,stockvalues.volume as volume From stocklist INNER JOIN  stockvalues WHERE stocklist.id = stockvalues.sid   AND stocklist.isWatch = 'no' AND stockvalues.id = (SELECT MAX(id) from stockvalues where sid = stocklist.id) and stockvalues.low BETWEEN $r1 AND $r2 order by stocklist.cSymbol";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}

function search_single_company_query($string) {

$query = "Select stocklist.id as id,stocklist.ntype as ntype,stocklist.notes as notes,stocklist.cSymbol as cSymbol,stocklist.sName as sName,stocklist.murl as murl,stocklist.curl as curl,stockvalues.open as currOpen,stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,stockvalues.volume as volume From stocklist INNER JOIN  stockvalues WHERE stocklist.id = stockvalues.sid   AND stocklist.isWatch = 'no' AND stockvalues.id = (SELECT MAX(id) from stockvalues where sid = stocklist.id) AND  stocklist.sName like '%$string%'order by stockvalues.volume desc";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}


function search_single_company_feature_query($string) {

    $query = "select * from stocklistfutures where isWatch='no' and cSymbol like '%$string%'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    while($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

    return $results;

}



?>
