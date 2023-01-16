<?php
//including common files
require_once './include/common.php';
require_once './template/header.php';

 //Checking stock already exists in table
    $id      =    $_GET['id'];
    $field     =  array("sName,murl,curl,cSymbol,notes");
    $table     =  "stocklist";
    $condition =  "id='$id'";
    $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
    $data      =  select($arugment,"one");

 ?>

<br/>
<center>
<form action="edit_process.php" method="post">

 <table class="gridtable">

 <tr>
     <td>Stock Name</td>
     <td>
       <input type="hidden" name="id" value="<?php echo $id ?>" />
       <input type="text" name="stock_name" readonly value="<?php echo $data['sName']?>"></td>
 </tr>
 
 <tr>
     <td>Money Control</td>
     <td><textarea name="murl" rows="5" cols="50"><?php echo $data['murl']?></textarea></td>
 </tr>
 
<tr>
     <td>ChartInk</td>
     <td><textarea name="curl" rows="5" cols="50"><?php echo $data['curl']?></textarea></td>
 </tr>

 <tr>
     <td>Notes</td>
     <td><textarea name="notes" rows="5" cols="50"><?php echo $data['notes']?></textarea></td>
 </tr>
 <tr>
     <td>Company Info</td>
     <?php

      $company = $data['cSymbol'];

     ?>
     <td><a href="https://www.google.com/search?q=<?php echo $company ?>+News+today" target="_blank">Company Info</a></td>
 </tr>

 <tr>
       <td colspan="2"><input type="submit" name="save" value="Save"></td>
</tr>

 </table>



 </form>
 </center>


 <?php
         if(!empty($_GET['msg'])) {
            echo  $_GET['msg'];
         }
  ?>
