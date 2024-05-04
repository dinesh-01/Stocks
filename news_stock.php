
<?php

//including common files
require_once './template/header.php';
require_once './include/common.php';


//Watchlist stocks in share calculator
    $type      =  "nifty";
    $field     =  array("id,sName,murl,curl,tickertape,id,qbuy,qvolume,qtotal,cSymbol,current_volume,stock_signal,order_type,stop_loss,target");
    $table     =  "stocklistIntra";
    $order     =  "sName";
    $condition =  "isWatch = 'yes' and priority = 4";
    $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition,"order" => $order);
    $data      =  select($arugment,"many");




//Getting symbol name
    $i = 0;
    foreach ($data as $value) {
            $data[$i]["symbol"] = $value['cSymbol'];
            $sid =  $value['id'];
            $data[$i]["priority"] = 4;
        $i++;
    }


    $smarty->assign("datas",$data);
    $smarty->display("news_stock.tpl");

?>

