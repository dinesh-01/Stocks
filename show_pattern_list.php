<script type="text/javascript">
 
 $(function() {
 $(".watch").click(function(){
 var element = $(this);
 var w_id = element.attr("id");
 var info = 'id=' + w_id;

  $.ajax({
    type: "POST",
    url: "watch_list_process.php",
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
    <th>Stock Name</th>
    <th>Money Control</th>
    <th>ChartInk</th>
    <th>Action</th>
</tr>


<?php

//Checking stock already exists in table
    $type      =  $_POST['t'];
    $pattern   =  $_POST['p'];
    $field     =  array("sName,murl,curl,id");
    $table     =  "stocklist";
    $condition =  "sType = '$type' and isWatch = 'no'";
    $order     =  "ntype";
    $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition,"order" => $order);
    $data      =  select($arugment,"many");
    
foreach ($data as $value) { 

           switch ($pattern) {
            case "nwindow":
                $result = window("nwindow",$value['id']);
                break;
            case "pwindow":
                $result = window("pwindow",$value['id']);
                break;
            case "phammer":
                $result = hammer("phammer",$value['id']);
                break;
            case "nhammer":
                $result = hammer("nhammer",$value['id']);
                break;
            case "alllow":
                $result = all_time_low($value['id']);
                break;    
            case "doji":
                $result = doji($value['id']);
                break;  
            case "gdoji":
                $result = gdoji($value['id']);
                break;    
             case "sptop":
                $result = sptop($value['id']);
                break;   
             case "enpattern":
                $result = enpattern($value['id']);
                break;        
            default:
               $result = false;
            }


 if($result == true) {       ?>

<tr class="show">
    <td>
        <a href="edit_stock.php?id=<?php echo $value['id']  ?>" target="blank"><?php echo $value['sName'] ?></a>
        <input type="hidden" id="sname" value="<?php echo $value['sName'] ?>"/> 
    </td>
    <td><a href="<?php echo $value['murl'] ?>" target="_blank">Money Control Link</a></td>
   <td><a href="<?php echo $value['curl']?>" target="_blank">ChartInk</a></td>
   <td><a href="javascript:void(0)" id="<?php echo $value['id']  ?>" class="watch" title="watch">WatchList</a></td>
</tr>

 <?php  } }  ?>


</table>

</center>