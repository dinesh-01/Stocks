<center>
<br/>


<center>
    
<div id="show_list">

<table class="gridtable">


<tr>
    <th> No </th>
    <th>Stock Name</th>
    <th>Symbol</th>
    <th>Money Control</th>
    <th>Chart</th>
    <th>Qunatity</th>
     <th>Buy Price</th>
    <th> Total </th>
    <th> Reset </th>
</tr>



{foreach $datas as $value name=count}
    

    <tr class="show">
        <td>{$smarty.foreach.count.iteration}</td>    
        <td>{$value.sName}<input type="hidden" id="sid" value="{$value.id}"/> </td>
        <td><a href = "https://www.google.com/search?q={$value.symbol}" target="_blank">{$value.symbol}</a></td>
        <td><a href="{$value.murl}" target="_blank">Money Control Link</a></td>
        <td><a href="{$value.curl}" target="_blank">ChartInk</a></td>
        <td>  <input type="text" name="qvolume" id="qvolume{$value.id}" size="7" value="{$value.qvolume}"
        onkeyup="show_calculator('{$value.id}')" />  </td>
        <td>  <input type="text" name="qbuy" id="qbuy{$value.id}" size="5" value="{$value.qbuy}" 
        onkeyup="show_calculator('{$value.id}')" />  </td>
        <td>  <input type="text" name="qtotal" id="qtotal{$value.id}" size="7" value="{$value.qtotal}" readonly="readonly" /> </td>
        <td> <input type="button" id="reset{$value.id}" value="Clear"  onclick="show_calculator_reset('{$value.id}')" /></td> 
    </tr>

{/foreach}

<tr >
    <td colspan="5"><b>All Total</b></td>
    <td colspan="2" ><span id="ttotals">{$totals}</span></td>
</tr>



</table>
</div>
</center>