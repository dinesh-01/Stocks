

<script src="../js/show_watch_list.js"></script>
<br/>


<center>
<div id="show_list">
  <table class="gridtable">
          <tr>
               <th>Symbol : <a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$details.name|replace:'-':'_'}" target="_blank">{$details.name}</a></th>
               <th>Price : {$details.stock_price}</th>
               <th><a href="future_margin_update.php?s={$details.name|replace:'-':'_'}">Update Margin</a> </th>
          </tr>
            <tr>
            <th> Future Symbol </th>
            <th> Future Price </th>
            <th> Lot-Size </th>
            <th> Margin Amount </th>
            <th> Actual Amount </th>
            <th> Status </th>
            </tr>

{foreach $datas as $value name=count}

    <tr class="show">
         <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.name}1%21" target="_blank">{$value.tradingsymbol}</a></td>
        <td>{$value.last_price}</td>
        <td>{$value.lot_size}</a></td>
        <td>{$value.strike}</a></td>
        <td>{$value.margin}</a></td>
        {if $value.order_status eq '0'}
        <td><a href="order_future.php?future_symbol={$value.tradingsymbol}&lot_size={$value.lot}&s={$details.name}"><button value="buy">BUY</button></a></td>
        {/if}

        {if $value.order_status eq '1'}
            <td>Completed</td>
        {/if}

    </tr>


{/foreach}



</table>
</div>
</center>
