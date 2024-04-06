<?php
//including common files
require_once './include/common.php';
require_once './template/header.php';


 ?>

<br/>
<center>
<form action="calculator_process.php" method="post" enctype="multipart/form-data">

 <table class="gridtable">

 <tr>
     <td>Amount</td>
     <td>
       <input type="text" name="amount" autocomplete="off">
     </td>
 </tr>

 <tr>
     <td>Percentage</td>
     <td><input type="text" name="percentage"  value="15"></td>
 </tr>
 


     <tr>
         <td>Target</td>
         <td><?php echo  $_GET['target'] ?></td>
     </tr>

     <tr>
         <td>Stop Loss</td>
         <td><?php echo  $_GET['stop'] ?></td>
     </tr>


     <tr>
       <td colspan="2"><input type="submit" name="submit" value="Submit"></td>
</tr>

 </table>



 </form>
 </center>

