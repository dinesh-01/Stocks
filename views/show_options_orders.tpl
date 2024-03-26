

<script src="js/show_watch_list.js"></script>
<br/>


<center>
<div id="show_list">
  <table class="gridtable">
          <tr>
              <th>Symbol : <a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$details.name|replace:'-':'_'}" target="_blank">{$details.name}</a></th>
              <th><a href="https://www.google.com/search?q={$details.name}+ grow+ option+chain" target="_blank">Option Chain</a></th>
           <th>Price : {$details.stock_price}</th>
          </tr>
            <tr>
            <th> Option Symbol </th>
            <th> Option Price </th>
            <th> Lot-Size </th>
            <th> Lot-Size To Buy </th>
                <th>Total Lot Amount </th>
            <th> Status </th>
            </tr>

{foreach $datas as $value name=count}

    <tr class="show">
         <td><a href="https://www.google.com/search?q={$value.name}+ grow+ option+chain" target="_blank">{$value.tradingsymbol}</a></td>
        <td>{$value.last_price}</td>
        <td>{$value.lot_size}</a></td>
        <td>{$value.lot}</a></td>
        <td>{$value.total_lot_prize}</a></td>

        {if $value.order_status eq '0'}
            <td><a href="order_option.php?option_symbol={$value.tradingsymbol}&lot_size={$value.lot}&s={$details.name}&o={$value.instrument_type}"><button value="buy">BUY</button></a></td>
        {/if}

        {if $value.order_status eq '1'}
            <td>Completed</td>
        {/if}

    </tr>


{/foreach}



</table>
</div>
</center>
