

<script src="js/show_watch_list.js"></script>
<br/>


<center>
<div id="show_list">
  <table class="gridtable">
          <tr>
              <th>Symbol : <a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$details.name|replace:'-':'_'}" target="_blank">{$details.name}</a></th>
           <th>Price : {$details.stock_price}</th>
          </tr>
            <tr>
            <th> Option Symbol </th>
            <th> Option Price </th>
            <th> Lot-Size </th>
            <th> Lot-Size To Buy </th>
            <th> Status </th>
            </tr>

{foreach $datas as $value name=count}

    <tr class="show">
         <td><a href="https://www.google.com/search?q={$value.name}+ grow+ option+chain" target="_blank">{$value.tradingsymbol}</a></td>
        <td>{$value.last_price}</td>
        <td>{$value.lot_size}</a></td>
        <td>{$value.lot}</a></td>
        <td><a href="update_option_price.php?id={$value.id}"><button value="buy">BUY</button></a></td>
    </tr>


{/foreach}



</table>
</div>
</center>
