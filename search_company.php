<?php

//including common files
require_once './include/common.php';
$r = $_POST['r'];

//Checking stock already exists in table
$data      =  search_single_company_query($r);

//Rending to tbl file 
$smarty->assign("datas",$data);
$smarty->display("search_company.tpl");

?>

   