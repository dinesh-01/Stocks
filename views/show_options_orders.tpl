

<script src="js/show_watch_list.js"></script>
<br/>

<center>
<div id="show_list">
  <table class="gridtable">
          <tr>
              <th>Symbol : <a href="https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A{$details.name|replace:'-':'_'}" target="_blank">{$details.name}</a></th>
              <th><a href="https://www.google.com/search?q={$details.name}+ grow+ option+chain" target="_blank">Option Chain</a></th>
           <th>Price : {$details.stock_price}</th>
          </tr>
            <tr>
            <th> Option Symbol </th>
            <th> Strike Price</th>
            <th> Option Price </th>
            <th> Lot-Size </th>
            <th> Lot-Size To Buy </th>
            <th> Volume </th>
            <th> Expiry Date </th>
            <th> Status </th>
            </tr>

{foreach $datas as $value name=count}

      <tr>


         <td><a href="https://groww.in/charts/options/nifty/{$value.tradingsymbol}?exchange=NSE" target="_blank">{$value.tradingsymbol}</td>
         <td>{$value.strike}</td>
        <td>{$value.last_price}</td>
        <td>{$value.lot_size}</td>
        <td>{$value.lot}</td>
        <td>{$value.volume}</td>
        <td>{$value.expiry}</td>
        {if $value.order_status eq '0'}
            <td><a href="order_option.php?option_symbol={$value.tradingsymbol}&lot_size={$value.lot}&s={$details.name}&o={$value.instrument_type}"><button value="buy">BUY</button></a></td>
        {/if}

        {if $value.order_status eq '1'}
            <td>Completed</td>
        {/if}

    </tr>


{/foreach}



</table>
    <br/>
    <button onClick="history.go(0);">Refresh Page</button>

</div>
</center>

