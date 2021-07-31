
<?php

//including common files
require_once './template/header.php';
require_once './include/common.php';


//Watchlist stocks in share calculator
    $type      =  "nifty";
    $field     =  array("sName,murl,curl,id,qbuy,qvolume,qtotal,cSymbol");
    $table     =  "stocklist";
    $order     =  "priority";
    $condition =  "isWatch = 'yes' and priority = 1";
    $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition,"order" => $order);
    $data      =  select($arugment,"many");

    $tField     = array("sum(qtotal) as totals");
    $tarugment  =  array( "field" => $tField , "table" => $table, "condition" => $condition);
    $tdata      =  select($tarugment,"one");


   //Getting symbol name
    $i = 0;
    foreach ($data as $value) {
            $data[$i]["symbol"] = get_company_detail($value['cSymbol'],"symbol");
            $i++;
    }



   //Rending to tbl file 
    $smarty->assign("datas",$data);
    $smarty->assign("total", $tdata['totals'] );
    $smarty->display("share_calculator.tpl");

?>

