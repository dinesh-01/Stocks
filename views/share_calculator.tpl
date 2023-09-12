<center>
<br/>


<center>
    
<div id="show_list">

<table class="gridtable">


<tr>
    <th> No </th>
    <th>Symbol</th>
    <th>Chart</th>
    <th>TradingView</th>
    <th>Current Volume </th>
    <th>Place Volume</th>
     <th>Buy Price</th>
    <th> Total </th>
    <th> Signal</th>
    <th> Order Type</th>
    <th> Target</th>
    <th> Stop Loss</th>
    <th> Reset </th>
</tr>



{foreach $datas as $value name=count}


    <tr class="show">
        <td>{$smarty.foreach.count.iteration}</td>    
        <td>
            <input type="hidden" id="sid" value="{$value.id}"/>
            <a href = "https://in.tradingview.com/symbols/NSE-{$value.symbol}" target="_blank">{$value.symbol}</a></td>
        <td><a href="{$value.curl}" target="_blank">ChartInk</a></td>
        <td><a href="https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A{$value.cSymbol}" target="_blank">TradingView</a></td>
        <td>  {$value.current_volume}  </td>
        <td>  <input type="text" name="qvolume" id="qvolume{$value.id}" size="7" value="{$value.qvolume}"
        onkeyup="show_calculator('{$value.id}')" />  </td>
        <td>  <input type="text" name="qbuy" id="qbuy{$value.id}" size="5" value="{$value.qbuy}" 
        onkeyup="show_calculator('{$value.id}')" />  </td>
        <td>  <input type="text" name="qtotal" id="qtotal{$value.id}" size="7" value="{$value.qtotal}" readonly="readonly"  /> </td>
        <td>
            {html_options onchange="show_calculator('{$value.id}')" name="stock_signal" id="stock_signal{$value.id}" options=$stock_signal selected="{$value.stock_signal}"}
        </td>
        <td>
            {html_options onchange="show_calculator('{$value.id}')" name="order_type" id="order_type{$value.id}" options=$order_type selected="{$value.order_type}"}
        </td>
        <td>  <input type="text" name="target" id="target{$value.id}" size="7" value="{$value.target}" readonly="readonly"  /> </td>
        <td>  <input type="text" name="stop_loss" id="stop_loss{$value.id}" size="7" value="{$value.stop_loss}" readonly="readonly"  /> </td>

        <td> <input type="button" id="reset{$value.id}" value="Clear"  onclick="show_calculator_reset('{$value.id}')" /></td> 
    </tr>

{/foreach}

<tr >
    <td colspan="4"><b>All Total</b></td>
    <td colspan="10" ><span id="ttotals">{$totals}</span></td>
</tr>
</table>

    <br>

    <a href="generate_json.php" target="_blank"> <h2> Generate Json </h2> </a>

</div>
</center>