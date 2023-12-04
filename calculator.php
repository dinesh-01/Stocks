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
     <td><input type="text" name="percentage" readonly value="10"></td>
 </tr>
 
<tr>
     <td>Option</td>
     <td><input type="radio" id="call" name="option" value="call">
         <label for="call">CALL</label><br>
         <input type="radio" id="put" name="option" value="put">
         <label for="put">PUT</label><br>
     </td>
 </tr>

     <tr>
         <td>Execute Amount</td>
         <td><?php echo  $_GET['amount'] ?></td>
     </tr>


     <tr>
       <td colspan="2"><input type="submit" name="submit" value="Submit"></td>
</tr>

 </table>



 </form>
 </center>

