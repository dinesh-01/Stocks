
<?php

//including common files
require_once './include/common.php';

//Checking stock already exists in table
    $type       =  $_POST['t'];
    $data       =  watch_list_query($type);

//Rending to tbl file
$smarty->assign("datas",$data);




$smarty->display("show_watch_list.tpl");

?>
