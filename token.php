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
<form action="token_process.php" method="post" enctype="multipart/form-data">

 <table class="gridtable">


 
 <tr>
     <td><a href="https://kite.zerodha.com/connect/login?v=3&api_key=asx9hj1ykmv09kgc" target="_blank">Copy Token</a></td>
     <td><textarea name="token" rows="5" cols="50"></textarea></td>
 </tr>

     <tr>
         <td colspan="2"><input type="submit" name="save" value="Generate Token"></td>
     </tr>

     <tr>
         <td colspan="2" align="center">
             <?php
             if(!empty($_GET['token_name'])) {
                 echo  $_GET['token_name'];
             }
             ?>

         </td>
     </tr>

 </table>



 </form>
 </center>



