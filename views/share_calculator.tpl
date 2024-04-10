<script src="js/show_watch_list.js"></script>


<center>
<br/>


<center>
    
<div id="show_list">

<table class="gridtable">


<tr>
    <th> No </th>
    <th>Symbol</th>
    <th>Trend Analysis</th>
    <th>Future Analysis</th>
    <th>Priority</th>
    <th>Monitor</th>
    <th>Action</th>
   <!-- <th> Reset </th> -->
</tr>



{foreach $datas as $value name=count}


    <tr class="show">
        <td>{$smarty.foreach.count.iteration}</td>    
        <td>
            <input type="hidden" id="sid" value="{$value.id}"/>
            <a href = "https://in.tradingview.com/symbols/NSE-{$value.symbol}" target="_blank">{$value.symbol}</a></td>
        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'|replace:'&':'_'}" target="_blank">Trend Layout</a></td>
        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'|replace:'&':'_'}1%21" target="_blank">Future Layout</a></td>




        <td>

            <select name="pri" id="pri{$value.id}" onchange="change_priority('{$value.id}');">
                <option value="1"  > 1 </option>
                <option value="2" selected="selected" }> 2 </option>
                <option value="3" > 3 </option>
                <option value="4" > 4 </option>
            </select>
        </td>

        <td>
            Support <input type="texbox" id="support_value{$value.id}" value="{$value.support_value}" size="7">
            Resistance <input type="texbox" id="resistance_value{$value.id}" value="{$value.resistance_value}" size="7">
            <button onclick="add_support('{$value.id}');"> ADD </button> &nbsp;

        </td>

        <td><a href="javascript:void(0)" id="{$value.id}" class="unwatch" title="unwatch">UnWatch</a></td>


        <!--   <td> <input type="button" id="reset{$value.id}" value="Clear"  onclick="show_calculator_reset('{$value.id}')" /></td>
       </tr>

       <script type="text/javascript">
           window.onload=show_calculator('{$value.id}')
       </script>
       -->

{/foreach}

 <!--
<tr >
    <td colspan="4"><b>All Total</b></td>
    <td colspan="10" ><span id="ttotals">{$totals}</span></td>
</tr>
-->
</table>

    <br>

   <!-- <a href="generate_json.php" target="_blank"> <h2> Generate Json </h2> </a> -->

</div>
</center>