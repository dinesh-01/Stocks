<script src="js/search_company.js"></script>

<br/>
<center>



<div id="show_list">
  <table class="gridtable">
            <tr>
            <th> No </th>
            <th>Stock Name</th>
            <th>TradingView</th>
            <th>ChartInk</th>
            <th> T.Open </th>
            <th> T.Close </th>
            <th> T.High </th>
            <th> T.Low </th>
            <th> Change </th>
            <th> Volume </th>
            <th>Action</th>
            </tr>
        
{foreach $datas as $value name=count}




    <tr class="show">
        <td> {$smarty.foreach.count.iteration} </td>    
        <td>
            <a href="edit_stock.php?id={$value.id}" title="{$value.notes}" target="blank">{$value.sName} [{$value.ntype}]</a>
            <input type="hidden" id="sname" value="{$value.sName}"/> 
            <input type="hidden" id="sid" value="{$value.id}"/> 
        </td>
        <td><a href="https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A{$value.cSymbol}" target="_blank">TradingView</a></td>
        <td><a href="{$value.curl}" target="_blank">ChartInk</a></td>
        <td>{$value.currOpen}</td>
        <td>{$value.currClose}</td>
        <td>{$value.currHigh}</td>
        <td>{$value.currLow}</td>
         <td>{$value.pChange}</td>
        <td>{$value.volume}</td>
        <td><a href="javascript:void(0)" id="{$value.id}" class="watch" title="watch">WatchList</a></td>
    </tr>


{/foreach}



</table>
</div>
</center>