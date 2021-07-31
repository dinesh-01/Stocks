<?php

function watch_list_query($type) {

    $builder = $GLOBALS['queryBuilder'];
    $qdate = $builder->select('max(createdDate)')->from('stockvalues');
    $rdate = $qdate->executeQuery()->fetchOne();

    echo $rdate;


    $query = $builder
               ->select('slist.id', 'slist.ntype','slist.notes',
                        'slist.sName','slist.murl','slist.curl',
                        'slist.priority','svalue.open as currOpen','svalue.high as currHigh',
                        'svalue.low as currLow','svalue.close as currClose',
                        'svalue.schange as pChange','svalue.volume as volume')
              ->from('stocklist','slist')
              ->innerJoin( 'slist', 'stockvalues','svalue')
              ->where('slist.id = svalue.sid',"slist.isWatch = 'yes'","slist.sType = '$type'","svalue.createdDate = '$rdate'")
              ->orderBy('slist.priority', 'ASC')
              ->distinct();

    $results = $query->executeQuery()->fetchAllAssociative();
    return $results;


}


function company_list_query($type) {

    $query = "Select stocklist.id as id,stocklist.ntype as ntype,stocklist.notes as notes,stocklist.sName as sName,stocklist.murl as murl,stocklist.curl as curl,stockvalues.open as currOpen,stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,stockvalues.volume as volume From stocklist INNER JOIN  stockvalues WHERE stocklist.id = stockvalues.sid AND stocklist.sType = '$type' AND stocklist.isWatch = 'no' ";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}


function company_list_range_query($r1,$r2) {


 $query = "Select stocklist.id as id,stocklist.ntype as ntype,stocklist.notes as notes,stocklist.sName as sName,stocklist.murl as murl,stocklist.curl as curl,stockvalues.open as currOpen,stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,stockvalues.volume as volume From stocklist INNER JOIN  stockvalues WHERE stocklist.id = stockvalues.sid   AND stocklist.isWatch = 'no' AND stockvalues.id = (SELECT MAX(id) from stockvalues where sid = stocklist.id) and stockvalues.low BETWEEN $r1 AND $r2 order by stockvalues.volume desc";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}

function search_single_company_query($string) {

$query = "Select stocklist.id as id,stocklist.ntype as ntype,stocklist.notes as notes,stocklist.sName as sName,stocklist.murl as murl,stocklist.curl as curl,stockvalues.open as currOpen,stockvalues.high as currHigh,stockvalues.low as currLow,stockvalues.close as currClose,stockvalues.schange as pChange,stockvalues.volume as volume From stocklist INNER JOIN  stockvalues WHERE stocklist.id = stockvalues.sid   AND stocklist.isWatch = 'no' AND stockvalues.id = (SELECT MAX(id) from stockvalues where sid = stocklist.id) AND  stocklist.sName like '%$string%'order by stockvalues.volume desc";

	$result = mysqli_query($GLOBALS['mysqlConnect'],$query);

	while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

     return $results;

}





?>
