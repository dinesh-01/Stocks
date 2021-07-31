<?php

//including common files
require_once './include/common.php';

$range = $_POST['r'];
$r = explode(",",$range);

//Search Using range
$data      =  company_list_range_query($r[0],$r[1]);

//Rending to tbl file 
$smarty->assign("datas",$data);
$smarty->display("list_stocks_range.tpl");
    
?>

 