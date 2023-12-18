
<?php

//including common files
require_once './include/common.php';

//Checking stock already exists in table
    $type       =  $_POST['t'];
    $data       =  watch_list_query($type);

//Rending to tbl file

$i = 0;

foreach ($data as $value) {

     $volume  = $value['volume'];
     $close   = $value['currClose'];


    $amount = $volume * $close;
    $turnover = convert_value_term($amount);
    $data[$i]['turnover'] = $turnover;
    $i++;


}


//Rending to tbl file
$smarty->assign("datas",$data);
$smarty->display("show_watch_list.tpl");

?>
