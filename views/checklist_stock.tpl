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
    <th>Price Selection</th>
    <th>Priority</th>
    <th>Action</th>
</tr>



{foreach $datas as $value name=count}


    <tr class="show">
        <td>{$smarty.foreach.count.iteration}</td>    
        <td>
            <input type="hidden" id="sid" value="{$value.id}"/>
            <a href = "https://in.tradingview.com/symbols/NSE-{$value.symbol}" target="_blank">{$value.symbol}</a></td>
        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'|replace:'&':'_'}" target="_blank">Trend Layout</a></td>
        <td><a href="https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'}" target="_blank">Price Layout</a></td>
        <td>

            <select name="pri" id="pri{$value.id}" onchange="change_priority('{$value.id}');">
                <option value="1" {if $value.priority eq 1}   selected="selected"  {/if}> 1 </option>
                <option value="2" {if $value.priority eq 2}   selected="selected"  {/if}> 2 </option>
                <option value="3" {if $value.priority eq 3}   selected="selected"  {/if}> 3 </option>
            </select>
        </td>
        <td><a href="javascript:void(0)" id="{$value.id}" class="unwatch" title="unwatch">UnWatch</a></td>
    </tr>



{/foreach}


</table>

    <br>


</div>
</center>