<?php
//including common files
require_once './include/common.php';
require_once './template/header.php';

 //Checking stock already exists in table
    $id      =    $_GET['id'];
    $field     =  array("order_id,symbol,price,quanity,stop_loss,target,status");
    $table     =  "stockAmoIntra";
    $condition =  "id='$id'";
    $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
    $data      =  select($arugment,"one");

 ?>

<br/>
<center>
<form action="edit_amo_process.php" method="post" enctype="multipart/form-data">

 <table class="gridtable">

 <tr>
     <td>Symbol</td>
     <td>
       <input type="hidden" name="id" value="<?php echo $id ?>" />
       <input type="text" name="symbol" readonly value="<?php echo $data['symbol']?>"></td>
 </tr>

     <tr>
         <td>Order Price</td>
         <td><input type="text" name="price"  value="<?php echo $data['price']?>"></td>
     </tr>
 
<tr>
     <td>Quantity</td>
    <td><input type="text" name="quanity"  value="<?php echo $data['quanity']?>"></td>
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
