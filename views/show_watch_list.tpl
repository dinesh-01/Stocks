
<link rel = "stylesheet" type = "text/css" href = "css/show_watch_list.css" />
<script src="js/show_watch_list.js"></script>


<center>
<div id="show_list">
  <table class="gridtable">
            <tr>
            <th> No </th>
            <th> Name</th>
            <th> Type</th>
            <th> Order</th>
            <th> Chart </th>
                <th> T.Close </th>
            <th> Change </th>
            <th> Volume </th>
            <th> TurnOver </th>
            <th>Action</th>
            <th>Priority</th>
            <th> Status </th>
            </tr>

{foreach $datas as $value name=count}

    <tr class="show">
        <td> {$smarty.foreach.count.iteration} </td>
        <td>
            <a href = "edit_stock.php?id={$value.id}" target="_blank">{$value.cSymbol}</a></td>
            <input type="hidden" id="sname" value="{$value.sName}"/>
            <input type="hidden" id="sid" value="{$value.id}"/>
        </td>

            <td><a href="https://www.google.com/search?q={$value.cSymbol}+ grow+ option+chain" target="_blank">{$value.ntype|capitalize}</a></td>


        <td>

            <a href="stock_options_orders.php?s={$value.cSymbol|replace:'-':'_'|replace:'&':'_'}&o=CE" target="_blank">CALL</a>
            ||
            <a href="stock_options_orders.php?s={$value.cSymbol|replace:'-':'_'|replace:'&':'_'}&o=PE" target="_blank">PUT</a>


        </td>

        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'|replace:'&':'_'}" target="_blank">Trend Layout</a></td>

        <!--
        <td><a href="https://www.google.com/search?q={$value.sName}%20grow%20option%20chain" target="_blank">List</a></td>
        <td><a href="{$value.curl}" target="_blank">ChartInk</a></td>


        <td>{$value.currOpen}</td>
        <td>{$value.currHigh}</td>
        <td>{$value.currLow}</td>
        --!>
        <td>{$value.currClose}</td>

         <td>{$value.pChange}</td>
        <td>{$value.volume}</td>
        <td> {$value.turnover}</td>
        <td><a href="javascript:void(0)" id="{$value.id}" class="unwatch" title="unwatch">UnWatch</a></td>
        <!--    <td> <a href="trend_list_view.php?sid={$value.id}"  target="_blank"> View Trends</a></td> -->
        <td>
           <select name="pri" id="pri{$value.id}" onchange="change_priority('{$value.id}');">
            <option value="1" {if $value.priority eq 1}   selected="selected"  {/if}> 1 </option>
            <option value="2" {if $value.priority eq 2}   selected="selected"  {/if}> 2 </option>
            <option value="3" {if $value.priority eq 3}   selected="selected"  {/if}> 3 </option>
           </select>
        </td>

        {if $value.order_status eq '0'}
            <td><a href="update_stock_price.php?id={$value.id}"><button value="buy">BUY</button></a></td>
        {/if}

        {if $value.order_status eq '1'}
            <td>Completed</td>
        {/if}



    </tr>


{/foreach}



</table>
</div>
</center>
