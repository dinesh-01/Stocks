<link rel = "stylesheet" type = "text/css" href = "css/show_watch_list.css" />
<script src="js/show_watch_list.js"></script>



<br/>
<center>
<div id="show_list">
  <table class="gridtable">
      <tr>
          <th colspan="2"><a href="clean_resistance_trend.php">Reset Support</a> </th>
      </tr>
        <tr>
        <th> No </th>
        <th> Stock  </th>
        <th> Option Chain </th>
        <th> Current Level </th>
        <th> Resistance Level  </th>
        <th> Watch List</th>

        </tr>

{foreach $datas as $value name=count}

    <tr class="show">
        <td> {$smarty.foreach.count.iteration} </td>

        <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.cSymbol|replace:'-':'_'|replace:'&':'_'}" target="_blank">{$value.cSymbol}</a></td>


        {if $value.grow eq ''}

            <td><a href="https://www.google.com/search?q={$value.cSymbol}%20grow%20option%20chain" target="_blank">List</a></td>
        {else}

            <td><a href="{$value.grow}" target="_blank">List</a></td>
        {/if}





        <td>{$value.last_price}</td>
        <td>{$value.support_value}</td>

        {if $value.isWatch eq 'yes'}

            <td>Present</td>
        {else}

            <td><a href="watch_list_process.php?id={$value.id}&redirect=yes">Add</a></td>
        {/if}




    </tr>


{/foreach}



</table>
</div>
</center>
