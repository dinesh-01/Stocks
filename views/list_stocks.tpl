<script src="js/list_stocks.js"></script>

<br/>
<center>


<select name = "range" id="range" onchange="show_range();">
  <option value="0,0">--Select--</option>
  <option value="1,200000">Stocks All Range</option>
  <option value="50,200">Stocks From 100-200 Range</option>
  <option value="200,500">Stocks From 200-500 Range</option>
  <option value="500,800">Stocks From 500-800 Range</option>
  <option value="800,1000">Stocks From 800-1000 Range</option>
  <option value="1000,200000">Stocks above 1000 Range</option>
</select>



Company name :- <input type="text" id="cname" onkeyup="search_company()">

<br/>
 <br/>




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
        <td><a href="https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'}" target="_blank">Stock Layout</a></td>
        <td><a href="https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'}1%21"  target="_blank">Future Layout</a></td>
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