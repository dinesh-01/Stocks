<?php

function watch_list_query($type,$priority=1) {

	 $query = "Select stocklistbackup.id as id,stocklistbackup.ntype as ntype,stocklistbackup.notes as notes,stocklistbackup.cSymbol as cSymbol,
               stocklistbackup.sName as sName,stocklistbackup.murl as murl,stocklistbackup.curl as curl,stocklistbackup.tickertape as ttape,
               stocklistbackup.priority as priority,stockvalues.open as currOpen,stockvalues.high as currHigh,
               stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,
               stockvalues.volume as volume From stocklistbackup INNER JOIN  stockvalues 
               WHERE stocklistbackup.id = stockvalues.sid AND stocklistbackup.isWatch = 'yes' AND stocklistbackup.priority = '$priority'  AND stocklistbackup.sType = '$type' AND stockvalues.id = (SELECT MAX(id) from stockvalues 
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
               stocklistbackup.murl as murl,stocklistbackup.curl as curl,stockvalues.open as currOpen,
               stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,
               stockvalues.schange as pChange,stockvalues.volume as volume From stocklistbackup 
               INNER JOIN  stockvalues WHERE stocklistbackup.id = stockvalues.sid AND $catagory  AND stocklistbackup.isWatch = 'no' order by stockvalues.id DESC LIMIT 0,50";
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


  $query = "Select stocklistbackup.id as id,stocklistbackup.ntype as ntype,stocklistbackup.cSymbol as cSymbol,stocklistbackup.notes as notes,stocklistbackup.sName as sName,stocklistbackup.murl as murl,stocklistbackup.curl as curl,stockvalues.open as currOpen,stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,stockvalues.volume as volume From stocklistbackup INNER JOIN  stockvalues WHERE stocklistbackup.id = stockvalues.sid   AND stocklistbackup.isWatch = 'no' AND stockvalues.id = (SELECT MAX(id) from stockvalues where sid = stocklistbackup.id) and stockvalues.low BETWEEN $r1 AND $r2 order by stockvalues.volume desc";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}

function search_single_company_query($string) {

$query = "Select stocklistbackup.id as id,stocklistbackup.ntype as ntype,stocklistbackup.notes as notes,stocklistbackup.cSymbol as cSymbol,stocklistbackup.sName as sName,stocklistbackup.murl as murl,stocklistbackup.curl as curl,stockvalues.open as currOpen,stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,stockvalues.volume as volume From stocklistbackup INNER JOIN  stockvalues WHERE stocklistbackup.id = stockvalues.sid   AND stocklistbackup.isWatch = 'no' AND stockvalues.id = (SELECT MAX(id) from stockvalues where sid = stocklistbackup.id) AND  stocklistbackup.sName like '%$string%'order by stockvalues.volume desc";

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



?>
