<?php

//including common files
require_once './include/common.php';
require_once './template/header.php';

?>
<br/>
<center>
<table class="gridtable">
<tr>
    <th>Stock Type</th>
    <th>
       <select name="type" id="type">
    <!-- <option value="penny"> -- Penny Lists -- </option> -->
         <option value="nifty" selected="selected"> -- Nifty Lists -- </option>
       </select>
   </th>
</tr>
<tr>
    <th>Click Pattern to Find</th>
    <th>
       <select name="pattern" id="pattern" onchange="show_pattern_list();">
       	 <option value=""> -- Select Pattern -- </option>
         <option value="alllow">All Time Low</option>
         <option value="doji"> Doji </option>
         <option value="nwindow"> Negative Window</option>
         <option value="phammer"> Positive Hammer </option>
         <option value="sptop"> Spining Top </option>
         <option value="enpattern"> Engulfing Pattern </option>
         <option value="nhammer"> Negative Hammer </option>
         <option value="pwindow"> Postive Window</option>
         <option value="bullcandle"> Bullish Candle</option>
         <option value="gdoji"> Grave Stone Doji </option>
       </select>
   </th>
</tr>
</table>
<br/>


<div id = "show_result"></div>


