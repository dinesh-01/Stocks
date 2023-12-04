<?php

//including common files
require_once './include/common.php';
$r = $_POST['r'];

//Checking stock already exists in table
$data      =  search_single_company_feature_query($r);

$i = 0;

foreach ($data as $value) {

    $param  = $value['cSymbol'];
    $symbol = $value['sName'];
    $turl = get_future_link($symbol,$param);
    $data[$i]['furl'] = $turl;
    $i++;


}


//Rending to tbl file 
$smarty->assign("datas",$data);
$smarty->display("search_futures_company.tpl");

?>

   