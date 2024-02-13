<br/>
<center>
<div id="show_list">
  <table class="gridtable">
            <tr>
            <th>NO</th>
            <th>  Symbol </th>
            <th> Future  </th>
            <th> Order Lot </th>
            <th> Order Price </th>
            <th> Order Market </th>
            <th> Current Status</th>
            <th> Execute Order </th>
            <th> Delete Order</th>
            </tr>

{foreach $datas as $value name=count}

    <tr class="show">
        <td> {$smarty.foreach.count.iteration} </td>
        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.stock_symbol|replace:'-':'_'}" target="_blank">{$value.stock_symbol}</a></td>
        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.stock_symbol|replace:'-':'_'}1%21" target="_blank">{$value.symbol}</a></td>
        <td>{$value.quanity}</td>
        <td>{$value.price}</a></td>
        <td>{$value.last_price}</a></td>
        <td>{$value.amount_diff}</a></td>
        <td><a href="order_future_sell_execute.php?id={$value.order_id}"><button value="sell">SELL</button></a></td>
        <td><a href="order_future_delete_execute.php?id={$value.order_id}"><button value="delete">DELETE</button></a></td>
    </tr>


{/foreach}



</table>
</div>
</center>
