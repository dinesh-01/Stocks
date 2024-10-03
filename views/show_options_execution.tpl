<br/>
<center>
<div id="show_list">
  <table class="gridtable">
            <tr>
            <th>NO</th>
            <th>  Symbol </th>
            <th> Chain </th>
            <th> Order Lot </th>
            <th> Order Price </th>
            <th> Order Market </th>
            <th> Current Status</th>
            <th> Exit Price</th>
            <th> Percentage </th>
            <th> Order Status</th>
            <!--
            <th> Trail SL  </th>
            -->
            <th> SELL </th>
            <th> Delete Order</th>
            </tr>

{foreach $datas as $value name=count}

    <tr class="show">
        <td><a href="order_amo_edit.php?id={$value.id}">{$smarty.foreach.count.iteration} </a>  </td>
        <td><a href="https://in.tradingview.com/chart/RVTxbc5U/?symbol=NSE%3A{$value.stock_symbol|replace:'-':'_'}" target="_blank">{$value.stock_symbol}</a></td>
        <td><a href="https://in.tradingview.com/chart/RVTxbc5U/?symbol={$value.url}" target="_blank">{$value.symbol}</td>
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
        <td>
            {$value.stop_loss_value}
        </td>
<td>
            {if $value.percentage gt 0}
                <font color="green">{$value.percentage}%</font>
            {else}
                <font color="red">{$value.percentage}%</font>
            {/if}

        </td>
        <td>{$value.track_status}</td>

<!--
        <td>
            {html_options name=foo id=$smarty.foreach.count.iteration options=$myOptions selected=$mySelect}
            <button value="sell" onclick="trail_execute('{$value.order_id}','{$smarty.foreach.count.iteration}')">Trail SL</button>
        </td>
-->
        <td><a href="order_option_execute.php?id={$value.id}"><button value="sl">SELL</button></a></td>
        <td><a href="order_option_delete_execute.php?id={$value.id}"><button value="delete">DELETE</button></a></td>
    </tr>


{/foreach}

      <tr>
          <td colspan="4">Overall</td>


          <td colspan="4">

              {if $overall_total gt 0}
                  <font color="green">{$overall_total}</font>
              {else}
                  <font color="red">{$overall_total}</font>
              {/if}

          </td>
          <td><a href="order_option_sell_execute_all.php"><button value="sell"><b>SELL&nbsp;ALL</b></button></a></td>

      </tr>



</table>
</div>
</center>
