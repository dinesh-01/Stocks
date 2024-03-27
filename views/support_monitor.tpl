


<br/>
<center>
<div id="show_list">
  <table class="gridtable">
        <tr>
        <th> No </th>
        <th> Stock  </th>
        <th> Option Chain </th>
        <th> Current Level </th>
        <th> Support Level  </th>

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



    </tr>


{/foreach}



</table>
</div>
</center>
