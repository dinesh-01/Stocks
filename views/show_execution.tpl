<br/>
<center>
<div id="show_list">
  <table class="gridtable">
            <tr>
            <th>NO</th>
            <th>  Symbol </th>
            <th>  Quantity </th>
            <th>  Price </th>
            <th>  Market </th>
            <th> Current Status</th>
            <th> Execute  </th>
            <!--    <th> Execute SL </th> -->
            <th> Delete Order</th>
            </tr>

{foreach $datas as $value name=count}

    <tr class="show">
        <td> {$smarty.foreach.count.iteration} </td>
        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.stock_symbol|replace:'-':'_'}" target="_blank">{$value.stock_symbol}</a></td>
        <td>{$value.quanity}</td>
        <td>{$value.price}</td>
        <td>{$value.last_price}</td>
        <td>

            {if $value.amount_diff gt 0}
                <font color="green">{$value.amount_diff}</font>
            {else}
                <font color="red">{$value.amount_diff}</font>
            {/if}

        </td>
        <td><a href="order_sell_execute.php?id={$value.order_id}"><button value="sell">SELL</button></a></td>
      <!--  <td><a href="order_option_sl.php?id={$value.order_id}"><button value="sl">STOPLOSS</button></a></td> -->
        <td><a href="order_delete_execute.php?id={$value.order_id}"><button value="delete">DELETE</button></a></td>
    </tr>


{/foreach}



</table>
</div>
</center>
