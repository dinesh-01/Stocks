<script src="js/search_company.js"></script>

<br/>
<center>

<div id="show_list">
    <table class="gridtable">
        <tr>
            <th> No </th>
            <th>Stock Name</th>
            <th>TradingView</th>
            <th>StockView</th>
            <th>Expiry</th>
            <th>Lot Size</th>
            <th>Volume</th>
            <th>Action</th>
        </tr>

        {foreach $datas as $value name=count}

            <tr class="show">
                <td> {$smarty.foreach.count.iteration} </td>
                <td>
                    <a href="https://in.tradingview.com/symbols/{$value.sName}"  target="blank">{$value.sName}</a>
                    <input type="hidden" id="sname" value="{$value.sName}"/>
                    <input type="hidden" id="sid" value="{$value.id}"/>
                </td>
                <td><a href="{$value.furl}" target="_blank">{$value.cSymbol}</a></td>
                <td><a href="https://in.tradingview.com/chart/bXKZrFip/?symbol=NSE%3A{$value.sName}" target="_blank">{$value.sName}</a></td>
                <td>{$value.expiry}</td>
                <td>{$value.lot_size}</td>
                <td>{$value.current_volume}</td>
                <td><a href="javascript:void(0)" id="{$value.id}" class="watch" title="watch">Watch</a></td>

            </tr>


        {/foreach}



    </table>
</div>
</center>