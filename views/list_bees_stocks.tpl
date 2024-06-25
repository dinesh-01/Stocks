<script src="js/list_stocks_bees.js"></script>

<br/>
<center>


    <a href="list_bees_stocks.php?list=yes">Show Watch List</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="list_bees_stocks.php?list=no">Show UnWatch List</a>


    <br/>
 <br/>

<div id="show_list">
  <table class="gridtable">
            <tr>
            <th> No </th>
            <th>Stock Name</th>
            <th>TradingView</th>
            <th>ChartInk</th>
            <th>Action</th>
            </tr>
        
{foreach $datas as $value name=count}




    <tr class="show">
        <td> {$smarty.foreach.count.iteration} </td>    
        <td>
            <a href="https://in.tradingview.com/symbols/{$value.cSymbol}"  target="blank">{$value.sName}</a>
            <input type="hidden" id="sname" value="{$value.sName}"/> 
            <input type="hidden" id="sid" value="{$value.id}"/> 
        </td>
        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.cSymbol}" target="_blank">{$value.cSymbol}</a></td>
        <td><a href="{$value.curl}" target="_blank">ChartInk</a></td>

        {if $type == "no" }
        <td><a href="javascript:void(0)" id="{$value.id}" class="watch" title="watch">Watch</a></td>
        {else}
        <td><a href="javascript:void(0)" id="{$value.id}" class="unwatch" title="unwatch">UnWatch</a></td>
        {/if}

    </tr>


{/foreach}



</table>
</div>
</center>