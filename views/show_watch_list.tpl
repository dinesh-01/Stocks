
<link rel = "stylesheet" type = "text/css" href = "css/show_watch_list.css" />
<script src="js/show_watch_list.js"></script>


<center>
<div id="show_list">
  <table class="gridtable">
        <tr>
        <th> No </th>
        <th> Name</th>
            <th> Option </th>
            <!--
                  <th> Future </th> -->
        <th> Stock chart </th>
      <!--      <th> Future chart </th>  -->
        <th>  List </th>



                <th>Action</th>
            </tr>

    {foreach $datas as $value name=count}

        <tr class="show">
            <td>
                <a href = "edit_stock.php?id={$value.id}" target="_blank">{$smarty.foreach.count.iteration}</a>
            </td>
            <td>
                <a href = "https://in.tradingview.com/symbols/NSE-{$value.cSymbol}" target="_blank">


                        {$value.sName}

                </a>
            </td>
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
        <td><a href="https://in.tradingview.com/chart/RVTxbc5U/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'|replace:'&':'_'}" target="_blank">Trend Layout</a></td>
        <!-- <td><a href="https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'}1%21"  target="_blank">Future Layout</a></td> -->


        {if $value.grow eq ''}

            <td><a href="https://www.google.com/search?q={$value.sName}%20grow%20option%20chain" target="_blank">List</a></td>
        {else}

            <td><a href="{$value.grow}" target="_blank">List</a></td>
        {/if}


        <!--
        <td><a href="{$value.curl}" target="_blank">ChartInk</a></td>



        <!--    <td> <a href="trend_list_view.php?sid={$value.id}"  target="_blank"> View Trends</a></td> -->


            <!--

        <td>
            Support <input type="texbox" id="support_value{$value.id}" value="{$value.support_value}" size="7">
            Resistance <input type="texbox" id="resistance_value{$value.id}" value="{$value.resistance_value}" size="7">
            <button onclick="add_support('{$value.id}');"> ADD </button> &nbsp;

        </td>

        -->



        <td><a href="javascript:void(0)" id="{$value.id}" class="unwatch" title="unwatch">UnWatch</a></td>



    </tr>


{/foreach}



</table>
</div>
</center>
