<?php

function watch_list_query($type) {

	 $query = "Select stocklist.id as id,stocklist.ntype as ntype,stocklist.notes as notes,stocklist.cSymbol as cSymbol,
               stocklist.sName as sName,stocklist.murl as murl,stocklist.curl as curl,stocklist.tickertape as ttape,
               stocklist.priority as priority,stockvalues.open as currOpen,stockvalues.high as currHigh,
               stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,
               stockvalues.volume as volume From stocklist INNER JOIN  stockvalues 
               WHERE stocklist.id = stockvalues.sid AND stocklist.isWatch = 'yes' AND stocklist.sType = '$type' AND stockvalues.id = (SELECT MAX(id) from stockvalues 
               where sid = stocklist.id) order by stocklist.priority asc";

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


function company_list_range_query($r1,$r2) {


 $query = "Select stocklist.id as id,stocklist.ntype as ntype,stocklist.cSymbol as cSymbol,stocklist.notes as notes,stocklist.sName as sName,stocklist.murl as murl,stocklist.curl as curl,stockvalues.open as currOpen,stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,stockvalues.volume as volume From stocklist INNER JOIN  stockvalues WHERE stocklist.id = stockvalues.sid   AND stocklist.isWatch = 'no' AND stockvalues.id = (SELECT MAX(id) from stockvalues where sid = stocklist.id) and stockvalues.low BETWEEN $r1 AND $r2 order by stockvalues.volume desc";

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





?>
