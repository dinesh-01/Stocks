<?php
//including common files
require_once './include/common.php';
require_once './template/header.php';

 ?>

<br/>
<center>
    <form action="add_stocks_process.php" method="post">

 <table class="gridtable">

 <tr>
     <td>Stock Name</td>
     <td><input type="text" name="stock_name" id="stock_name" value=""></td>
 </tr>
 
 <tr>
     <td>Money Control</td>
     <td><textarea name="murl" rows="5" cols="50"></textarea></td>
 </tr>
 
<tr>
     <td>ChartInk</td>
     <td><textarea name="curl" rows="5" cols="50"></textarea></td>
 </tr>
 
 <tr>
     <td>Stock Type</td>
    <td>
       <select name="type" id="type" onchange="show_watch_list();">
       <option value="penny" > -- Penny Lists -- </option>  
        <option value="nifty" selected="selected" > -- Nifty Lists -- </option>
       </select>
   </td>
</tr>
     </td>
 </tr>

 <tr>
     <td>Notes</td>
     <td><textarea name="notes" rows="5" cols="50"></textarea></td>
 </tr>
 <tr>
     <td>Company Info</td>
     <td><input type="text" size="40" name="company_info" id="company_info" value=""></td>
 </tr>

 <tr>
       <td colspan="2"><input type="submit" name="Add" value="Save"></td>
</tr>

 </table>



 </form>
 </center>


 <?php
         if(!empty($_GET['msg'])) {
            echo  $_GET['msg'];
         }
  ?>
