<?php
//including common files
require_once './include/common.php';
require_once './template/header.php';

 //Checking stock already exists in table
    $field     =  array("cSymbol");
    $table     =  "stocklist";
    $condition =  "priority=2 and isWatch = 'yes'";
    $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
    $data      =  select($arugment,"many");

 ?>

<br/>
<body onload="select_option()">
<center>
<form action="option_trigger_process.php" method="post"  enctype="multipart/form-data">

 <table class="gridtable">

 <tr>
     <td>Stock Names</td>
     <td>
         <select name="stocks" id="stocks" onchange="select_option()">

             <?php foreach ($data as $symbol) { ?>
                 <option value="<?php echo $symbol['cSymbol'] ?>"> -- <?php echo $symbol['cSymbol'] ?> -- </option>
              <?php   } ?>

         </select>


     </td>
 </tr>

     <tr>
       <td>   Options list </td>
     <td>
         <div id="option_view"> </div>
     </td>
     </tr>

     <tr>

     <tr>
         <td>   Options Symbol </td>
         <td><input type="text" name="option_symbol" autocomplete="off" size="25"></td>
     </tr>

     <tr>
        <td>Strike Price</td>
         <td><input type="text" name="option_to_buy" autocomplete="off" size="25"></td>
     </tr>

     <?php
     if(!empty($_GET['msg'])) { ?>
         <tr>
             <td colspan="2"><?php echo $_GET['msg']?></td>
         </tr>
     <?php } ?>



     <tr>
         <td><input type="submit" name="save" value="Save"></td>
         <td><a href="cron_option_trigger.php" target="_blank">Cron Status</a> </td>

     </tr>

 </table>



 </form>
 </center>
</body>



