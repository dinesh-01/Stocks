
<link rel = "stylesheet" type = "text/css" href = "css/show_watch_list.css" />
<script src="js/show_watch_list.js"></script>


<center>
<div id="show_list">
  <table class="gridtable">
            <tr>
            <th> No </th>
            <th>Stock Name</th>
            <th>Money Control</th>
            <th>ChartInk</th>
            <th> T.Open </th>
            <th> T.Close </th>
            <th> T.High </th>
            <th> T.Low </th>
            <th> Change </th>
            <th> Volume </th>
            <th>Action</th>
            <th>Priority</th>
            </tr>

{foreach $datas as $value name=count}

    <tr class="show">
        <td> {$smarty.foreach.count.iteration} </td>
        <td>
            <a href="edit_stock.php?id={$value.id}" title="{$value.notes}" target="blank">{$value.sName} [{$value.ntype}]</a>
            <input type="hidden" id="sname" value="{$value.sName}"/>
            <input type="hidden" id="sid" value="{$value.id}"/>
        </td>
        <td><a href="{$value.murl}" target="_blank">Money Control Link</a></td>
        <td><a href="{$value.curl}" target="_blank">ChartInk</a></td>
        <td>{$value.currOpen}</td>
        <td>{$value.currClose}</td>
        <td>{$value.currHigh}</td>
        <td>{$value.currLow}</td>
         <td>{$value.pChange}</td>
        <td>{$value.volume}</td>
        <td><a href="javascript:void(0)" id="{$value.id}" class="unwatch" title="unwatch">UnWatch</a></td>
        <td>
           <select name="pri" id="pri{$value.id}" onchange="change_priority('{$value.id}');">
            <option value="1" {if $value.priority eq 1}   selected="selected"  {/if}> 1 </option>
            <option value="2" {if $value.priority eq 2}   selected="selected"  {/if}> 2 </option>
            <option value="3" {if $value.priority eq 3}   selected="selected"  {/if}> 3 </option>
           </select>
        </td>
    </tr>


{/foreach}



</table>
</div>
</center>
