<?php
//including common files
require_once './include/common.php';
require_once './template/header.php';

 //Checking stock already exists in table
    $id      =    $_GET['id'];
    $field     =  array("*");
    $table     =  "optionAmo";
    $condition =  "id='$id'";
    $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition);
    $data      =  select($arugment,"one");

        $options = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10'
        ];

 ?>

<br/>
<center>
<form action="order_amo_edit_process.php" method="post" enctype="multipart/form-data">

 <table class="gridtable">

 <tr>
     <td>Option Symbol</td>
     <td>
       <input type="hidden" name="id" value="<?php echo $id ?>" />
       <?php echo $data['symbol']?>
     </td>
 </tr>

<tr>
    <td>Trigger Value</td>
    <td><input type="text" name="trigger_value" autocomplete="off" value="<?php echo $data['trigger_value']?>"></td>

</tr>

     <tr>
         <td>Support Value</td>
         <td><input type="text" name="support_value" autocomplete="off" value="<?php echo $data['support_value']?>"></td>

     </tr>


     <tr>
         <td>Last Price</td>
         <td><input type="text" name="price" autocomplete="off" value="<?php echo $data['price']?>"></td>

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
