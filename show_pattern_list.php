<script type="text/javascript">
 
 $(function() {
 $(".watch").click(function(){
 var element = $(this);
 var w_id = element.attr("id");
 var info = 'id=' + w_id;
 var dtype = $("#dtype").val();
 var wurl = ""

 if(dtype == "stocks") {
     wurl = "watch_list_process.php"
 }

 if(dtype == "futures") {
     wurl = "watch_list_process_futures.php"
 }


     $.ajax({
    type: "POST",
    url: wurl,
    data: info,
    success: function(){}
 });
   $(this).parents(".show").animate({ backgroundColor: "#003" }, "fast")
   .animate({ opacity: "hide" }, "fast");
 });
 });

 </script>



<?php

//including common files
require_once './include/common.php';

?>


<center>
    
<table class="gridtable">
<tr>
    <th> NO </th>
    <th>Stock Name</th>
    <th>TradingView</th>
    <th>ChartInk</th>
    <th>Action</th>
</tr>


<?php

//Checking stock already exists in table
    $type      =  $_POST['t'];
    $pattern   =  $_POST['p'];

    if($type == "stocks") {

        $field     =  array("sName,murl,curl,id,cSymbol,tickertape,dtype");
        $table     =  "stocklist";
        $condition =  "isWatch = 'no'";
        $order     =  "ntype";
        $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition,"order" => $order);
        $data      =  select($arugment,"many");


    }

    if($type == "futures") {

        $field     =  array("sName,cSymbol,expiry,id,lot_size,dtype");
        $table     =  "stocklistfutures";
        $condition =  "isWatch = 'no'";
        $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
        $data      =  select($arugment,"many");


    }

 $c=1;

foreach ($data as $value) { 

           switch ($pattern) {
            case "nwindow":
                $result = window("nwindow",$value['id'],$type);
                break;
            case "pwindow":
                $result = window("pwindow",$value['id'],$type);
                break;
            case "phammer":
                $result = hammer("phammer",$value['id'],$type);
                break;
            case "nhammer":
                $result = hammer("nhammer",$value['id'],$type);
                break;
            case "alllow":
                $result = all_time_low($value['id'],$type);
                break;
            case "allhigh":
               $result = all_time_high($value['id'],$type);
               break;
            case "doji":
                $result = doji($value['id'],$type);
                break;  
            case "gdoji":
                $result = gdoji($value['id'],$type);
                break;    
            case "sptop":
                $result = sptop($value['id'],$type);
                break;
            case "morningstar":
               $result = morningstar($value['id'],$type);
               break;
            case "brtrap":
               $result = brtrap($value['id'],$type);
               break;
           case "dfdoji":
               $result = dfdoji($value['id'],$type);
               break;
            case "eveningstar":
               $result = eveningstar($value['id'],$type);
               break;
            case "enpattern":
                $result = enpattern($value['id'],$type);
                break;
            case "pipattern":
               $result = pipattern($value['id'],$type);
               break;
            case "darkcover":
               $result = darkcover($value['id'],$type);
               break;
            case "betrap":
               $result = betrap($value['id'],$type);
               break;
            case "brpattern":
               $result = brpattern($value['id'],$type);
               break;
            case "longbullish":
               $result = longbullish($value['id'],$type);
               break;
            case "longbearish":
               $result = longbearish($value['id'],$type);
               break;
            case "upward":
               $result = upward($value['id'],$type);
               break;
            default:
               $result = false;
            }


 if($result == 1) {   ?>

<tr class="show">
    <td><?php echo $c ?></td>
    <td>
        <?php echo $value['cSymbol'] ?>
        <input type="hidden" id="sname" value="<?php echo $value['sName'] ?>"/>
        <input type="hidden" id="dtype" value="<?php echo $value['dtype'] ?>"/>
    </td>


    <?php

    $param = $value['cSymbol'];

        if($type == "stocks") {

            if(str_contains($param,"&")) {
                $param = str_replace("&", "_", $param);
            }

            if(str_contains($param,"-")) {
                $param = str_replace("-", "_", $param);
            }

            $turl = "https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A$param";
        }

        if($type == "futures") {

            $param = strtolower($param);
            $currentmonth = strtolower(date('M'));
            $nextmonth = strtolower(date('M',strtotime('first day of +1 month')));
            $futuremonth = strtolower(date('M',strtotime('first day of +2 month')));
            $symbol = $value['sName'];


            if(str_contains($param, $currentmonth)) {
                $turl = "https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A".$symbol."X2023";
            }

            if(str_contains($param, $nextmonth)) {
                $turl = "https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A".$symbol."Z2023";
            }

            if(str_contains($param, $futuremonth)) {
                $turl = "https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A".$symbol."f2024";
            }


        }

    ?>

    <td><a href="<?php echo $turl ?>" target="_blank">TradingView</a></td>

    <td><a href="<?php echo $value['curl']?>" target="_blank">ChartInk</a></td>
    <td><a href="javascript:void(0)" id="<?php echo $value['id']  ?>" class="watch" title="watch">WatchList</a></td>
</tr>

 <?php  $c++; } }  ?>


</table>

</center>