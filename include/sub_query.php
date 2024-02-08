<?php



function watch_list_query($type,$priority=1) {

    global $stockListTable;
    $query = "Select $stockListTable.id as id,$stockListTable.ntype as ntype,$stockListTable.notes as notes,$stockListTable.cSymbol as cSymbol,
               $stockListTable.sName as sName,$stockListTable.murl as murl,$stockListTable.order_status as order_status,$stockListTable.curl as curl,$stockListTable.tickertape as ttape,
               $stockListTable.priority as priority,stockvalues.open as currOpen,stockvalues.high as currHigh,
               stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,
               stockvalues.volume as volume From $stockListTable INNER JOIN  stockvalues 
               WHERE $stockListTable.id = stockvalues.sid AND $stockListTable.isWatch = 'yes' AND $stockListTable.priority = '$priority'  AND $stockListTable.sType = '$type' AND stockvalues.id = (SELECT MAX(id) from stockvalues 
               where sid = $stockListTable.id) order by $stockListTable.sName asc";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}


function company_list_query($type) {


    global $stockListTable;
    if($type == "nifty") {
       $catagory = "$stockListTable.sType = '$type'";
    }

    if($type == "N50") {
        $catagory = "$stockListTable.ntype = '$type'";
    }

    $query = "Select $stockListTable.id as id,$stockListTable.ntype as ntype,$stockListTable.cSymbol as cSymbol,$stockListTable.notes as notes,$stockListTable.sName as sName,
               $stockListTable.murl as murl,$stockListTable.curl as curl,stockvalues.open as currOpen,
               stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,
               stockvalues.schange as pChange,stockvalues.volume as volume From $stockListTable 
               INNER JOIN  stockvalues WHERE $stockListTable.id = stockvalues.sid AND $catagory  AND $stockListTable.isWatch = 'no' order by stockvalues.id DESC LIMIT 0,50";
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

    $query = "SELECT * FROM `$stockListTablefutures` where `isWatch` = '$type'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    while($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

    return $results;

}


function company_list_range_query($r1,$r2) {


    global $stockListTable;
    $query = "Select $stockListTable.id as id,$stockListTable.ntype as ntype,$stockListTable.cSymbol as cSymbol,$stockListTable.notes as notes,$stockListTable.sName as sName,$stockListTable.murl as murl,$stockListTable.curl as curl,stockvalues.open as currOpen,stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,stockvalues.volume as volume From $stockListTable INNER JOIN  stockvalues WHERE $stockListTable.id = stockvalues.sid   AND $stockListTable.isWatch = 'no' AND stockvalues.id = (SELECT MAX(id) from stockvalues where sid = $stockListTable.id) and stockvalues.low BETWEEN $r1 AND $r2 order by stockvalues.volume desc";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}

function search_single_company_query($string) {

    global $stockListTable;
    $query = "Select $stockListTable.id as id,$stockListTable.ntype as ntype,$stockListTable.notes as notes,$stockListTable.cSymbol as cSymbol,$stockListTable.sName as sName,$stockListTable.murl as murl,$stockListTable.curl as curl,stockvalues.open as currOpen,stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,stockvalues.volume as volume From $stockListTable INNER JOIN  stockvalues WHERE $stockListTable.id = stockvalues.sid   AND $stockListTable.isWatch = 'no' AND stockvalues.id = (SELECT MAX(id) from stockvalues where sid = $stockListTable.id) AND  $stockListTable.sName like '%$string%'order by stockvalues.volume desc";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}


function search_single_company_feature_query($string) {

    $query = "select * from $stockListTablefutures where isWatch='no' and cSymbol like '%$string%'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    while($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

    return $results;

}



?>
