
<?php

//including common files
require_once './template/header.php';
require_once './include/common.php';


//Watchlist stocks in share calculator
    $type      =  "nifty";
    $field     =  array("id,sName,murl,curl,ntype,tickertape,id,qbuy,qvolume,qtotal,cSymbol,current_volume,stock_signal,order_type,stop_loss,target");
    $table     =  "$stockListTable";
    $order     =  "ntype";
    $condition =  "isWatch = 'yes' and priority = 2";
    $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition,"order" => $order);
    $data      =  select($arugment,"many");

    $tField     = array("sum(qtotal) as totals");
    $tarugment  =  array( "field" => $tField , "table" => $table, "condition" => $condition);
    $tdata      =  select($tarugment,"one");



//Getting symbol name
    $i = 0;
    foreach ($data as $value) {
            $data[$i]["symbol"] = $value['cSymbol'];
            $sid =  $value['id'];


          if(empty($value['qbuy']) ) {

              $field = array("close");
              $table = "stockvalues";
              $order = "id desc limit 0,1";
              $condition = "sid = '$sid' ";
              $vrugment = array("field" => $field, "table" => $table, "condition" => $condition, "order" => $order);
              $vdata = select($vrugment, "one");

              $data[$i]["qbuy"] = $vdata['close'];

          }

        $i++;
    }



   //Rending to tbl file
     $smarty->assign('stock_signal', array(
        'SELECT' => '=> SELECT <=',
        'BUY' => 'BUY',
        'SELL' => 'SELL')
     );

    //Rending to tbl file
     $smarty->assign('order_type', array(
        'SELECT' => '=> SELECT <=',
        'MARKET' => 'MARKET',
        'LIMIT' => 'LIMIT')
     );

        //Rending to tbl file
        $smarty->assign('qprice', array(
                '25000' => '25K',
                '50000' => '50K',
                '75000' => '75K',
                '100000' => '1L',
                )
        );

    $smarty->assign("datas",$data);
    $smarty->assign("total", $tdata['totals'] );
    $smarty->display("share_calculator.tpl");

?>

