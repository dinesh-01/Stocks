
<link rel = "stylesheet" type = "text/css" href = "css/show_watch_list.css" />
<script src="js/show_watch_list.js"></script>


<center>
<div id="show_list">
  <table class="gridtable">
        <tr>
        <th> No </th>
        <th> Name</th>
              <th> Option </th>
            <!--       <th> Future </th> -->
        <th> Stock chart </th>
      <!--      <th> Future chart </th>  -->
        <th>  List </th>
        <th> T.Close </th>
        <th> Change </th>
        <th> Volume </th>
        <th> TurnOver </th>

        <th>Priority</th>
        <th>Monitor</th>
        <th> Status </th>
            <th>Action</th>
        </tr>

{foreach $datas as $value name=count}

    <tr class="show">
        <td> {$smarty.foreach.count.iteration} </td>
        <td>
            <a href = "edit_stock.php?id={$value.id}" target="_blank">{$value.cSymbol}</a></td>
            <input type="hidden" id="sname" value="{$value.sName}"/>
            <input type="hidden" id="sid" value="{$value.id}"/>
        </td>



        <td>

            <a href="stock_options_orders.php?s={$value.cSymbol|replace:'-':'_'|replace:'&':'_'}&o=CE" target="_blank">CALL</a>
            ||
            <a href="stock_options_orders.php?s={$value.cSymbol|replace:'-':'_'|replace:'&':'_'}&o=PE" target="_blank">PUT</a>


        </td>
        <!--
          <td>  <a href="stock_future_orders.php?s={$value.cSymbol|replace:'-':'_'|replace:'&':'_'}" target="_blank">Future</a> </td>
         -->
        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'|replace:'&':'_'}" target="_blank">Trend Layout</a></td>
        <!-- <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'}1%21"  target="_blank">Future Layout</a></td> -->


        {if $value.grow eq ''}

            <td><a href="https://www.google.com/search?q={$value.sName}%20grow%20option%20chain" target="_blank">List</a></td>
        {else}

            <td><a href="{$value.grow}" target="_blank">List</a></td>
        {/if}


        <!--
        <td><a href="{$value.curl}" target="_blank">ChartInk</a></td>


        <td>{$value.currOpen}</td>
        <td>{$value.currHigh}</td>
        <td>{$value.currLow}</td>
        --!>
        <td>{$value.currClose}</td>

         <td>{$value.pChange}</td>
        <td>{$value.volume}</td>
        <td> {$value.turnover}</td>
        <!--    <td> <a href="trend_list_view.php?sid={$value.id}"  target="_blank"> View Trends</a></td> -->
        <td>
           <select name="pri" id="pri{$value.id}" onchange="change_priority('{$value.id}');">
            <option value="1" {if $value.priority eq 1}   selected="selected"  {/if}> 1 </option>
            <option value="2" {if $value.priority eq 2}   selected="selected"  {/if}> 2 </option>
            <option value="3" {if $value.priority eq 3}   selected="selected"  {/if}> 3 </option>
            <option value="4" {if $value.priority eq 4}   selected="selected"  {/if}> 4 </option>
           </select>
        </td>

        <td>
            Support <input type="texbox" id="support_value{$value.id}" value="{$value.support_value}" size="7">
            Resistance <input type="texbox" id="resistance_value{$value.id}" value="{$value.resistance_value}" size="7">
            <button onclick="add_support('{$value.id}');"> ADD </button> &nbsp;

        </td>

        {if $value.order_status eq '0'}
            <td><a href="update_stock_price.php?id={$value.id}"><button value="buy">BUY</button></a></td>
        {/if}

        {if $value.order_status eq '1'}
            <td>Completed</td>
        {/if}

        <td><a href="javascript:void(0)" id="{$value.id}" class="unwatch" title="unwatch">UnWatch</a></td>



    </tr>


{/foreach}



</table>
</div>
</center>
