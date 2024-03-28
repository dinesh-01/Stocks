<script src="js/list_stocks_range.js"></script>

<br/>
<center>



<div id="show_list">
  <table class="gridtable">
            <tr>
            <th> No </th>
            <th>Stock Name</th>
                <th>Stock</th>
            <th>Future</th>
            <th> T.Open </th>
            <th> T.Close </th>
            <th> T.High </th>
            <th> T.Low </th>
            <th> Change </th>
            <th> Volume </th>
                <th>Support</th>
            <th>Action</th>
            </tr>
        
{foreach $datas as $value name=count}


   <!-- https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'}1%21
    <br/>
    -->

    <tr class="show">
        <td> {$smarty.foreach.count.iteration} </td>    
        <td>
            <a href="edit_stock.php?id={$value.id}" title="{$value.notes}" target="blank">{$value.sName} [{$value.ntype}]</a>
            <input type="hidden" id="sname" value="{$value.sName}"/> 
            <input type="hidden" id="sid" value="{$value.id}"/> 
        </td>
        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'}" target="_blank">Single Layout</a></td>
        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'}1%21"  target="_blank">Future Layout</a></td>

        <td>{$value.currOpen}</td>
        <td>{$value.currClose}</td>
        <td>{$value.currHigh}</td>
        <td>{$value.currLow}</td>
         <td>{$value.pChange}</td>
        <td>{$value.volume}</td>
        <td>
            <input type="texbox" id="support_value{$value.id}" value="{$value.support_value}" size="10">
            <button onclick="add_support('{$value.id}');"> ADD </button> &nbsp;
            <button onclick="add_support('{$value.id}');"> CLEAR </button>

        </td>
        <td><a href="javascript:void(0)" id="{$value.id}" class="watch" title="watch">WatchList</a></td>
    </tr>


{/foreach}



</table>
</div>
</center>