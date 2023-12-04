
<?php

//including common files
require_once './include/common.php';
require_once './template/header.php';

    //Checking stock already exists in table
    $type       =  $_GET['list'];
    $data       =  company_list_future_query($type);
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
    $smarty->assign("type",$type);
    $smarty->display("list_futures_stocks.tpl");
    
            
?>