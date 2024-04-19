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
           <option value="stocks" selected="selected"> -- Stocks -- </option>
           <option value="futures"> -- Futures -- </option>
       </select>
   </th>
</tr>
<tr>
    <th>Click Pattern to Find</th>
    <th>
       <select name="pattern" id="pattern" onchange="show_pattern_list();">
       	  <option value=""> -- Select Pattern -- </option>

           <optgroup label="Bullish Pattern">
           <option value="drdoji"> DragonFly Doji </option>
           <option value="phammer"> Hammer </option>
           <option value="morningstar"> Morning Star </option>
           <option value="enpattern"> Engulfing Pattern </option>
           <option value="pipattern"> Piercing Pattern </option>
           <option value="pwindow"> Rising Window</option>
           <option value="brtrap"> BullishTrap Pattern </option>
           </optgroup>



           <optgroup label="Bearish Pattern">
               <option value="gdoji"> Grave Stone Doji </option>

               <!--
               <option value="eveningstar"> Evening Star </option>
               <option value="darkcover"> Dark Cover </option>
               <option value="brpattern"> Bearish Engulfing Pattern </option>
               <option value="nhammer"> Hanging  </option>
               <option value="nwindow"> Falling Window</option>
               <option value="betrap"> BearishTrap Pattern </option>
               -->
               </optgroup>

               <optgroup label="Decision Pattern">
               <option value="sptop"> Spining Top </option>
               <option value="doji"> Doji </option>
               <option value="longbullish"> Long Bullish </option>
               <option value="longbearish"> Long Bearish </option>
              <!--<option value="alllow">All Time Low</option>
              <option value="upward">Upward</option>
              <option value="allhigh">All Time High</option> -->
           </optgroup>


       </select>
   </th>
</tr>
</table>
<br/>

<div id="candle_sample"></div>

<div id = "show_result">


</div>


