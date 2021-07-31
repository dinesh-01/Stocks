
<?php

//including common files
require_once './include/common.php';
require_once './template/header.php';

    //Checking stock already exists in table
    $type      =  $_GET['t'];
    $data       =  company_list_query($type);
    
    //Rending to tbl file 
    $smarty->assign("datas",$data);
    $smarty->assign("type",$type);
    $smarty->display("list_stocks.tpl"); 
    
            
?>