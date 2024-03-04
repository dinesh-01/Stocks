<?php
//including common files
require_once './include/common.php';
require_once './template/header.php';


 ?>

<br/>
<center>
<form action="interest_process.php" method="post" enctype="multipart/form-data">

 <table class="gridtable">

 <tr>
     <td>Total Amount</td>
     <td>
       <input type="text" name="amount" autocomplete="off">
     </td>
 </tr>
 
 <tr>
     <td>Amount Given</td>
     <td><input type="text" name="amount_given"  autocomplete="off"></td>
 </tr>

     <tr>
         <td>Principle</td>
         <td><?php echo  $_GET['principle'] ?></td>
     </tr>



     <tr>
         <td>Interest</td>
         <td><?php echo  $_GET['interest'] ?></td>
     </tr>

     <tr>
         <td>Pending Amount</td>
         <td><?php echo  $_GET['pending_amount'] ?></td>
     </tr>


     <tr>
       <td colspan="2"><input type="submit" name="submit" value="Submit"></td>
</tr>

 </table>



 </form>
 </center>

