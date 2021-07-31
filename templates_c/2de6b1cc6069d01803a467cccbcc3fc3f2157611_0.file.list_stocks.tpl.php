<?php
/* Smarty version 3.1.30, created on 2016-11-04 15:50:32
  from "C:\xampp\htdocs\analytics\views\list_stocks.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_581ca038602dd8_24980470',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2de6b1cc6069d01803a467cccbcc3fc3f2157611' => 
    array (
      0 => 'C:\\xampp\\htdocs\\analytics\\views\\list_stocks.tpl',
      1 => 1478271024,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_581ca038602dd8_24980470 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 src="js/list_stocks.js"><?php echo '</script'; ?>
>

<br/>
<center>

<?php if ($_smarty_tpl->tpl_vars['type']->value == "penny") {?>   

<select name = "range" id="range" onchange="show_range();">
  <option value="0,0">--Select--</option>
  <option value="1,5">Stocks From 1-5 Range</option>
  <option value="5,10">Stocks From 5-10 Range</option>
  <option value="10,15">Stocks From 10-15 Range</option>
  <option value="15,20">Stocks From 15-20 Range</option>
  <option value="20,30">Stocks above 20 Range</option>
</select>

<?php }?>


<?php if ($_smarty_tpl->tpl_vars['type']->value == "nifty") {?>   

<select name = "range" id="range" onchange="show_range();">
  <option value="0,0">--Select--</option>
  <option value="50,200">Stocks From 100-200 Range</option>
  <option value="200,500">Stocks From 200-500 Range</option>
  <option value="500,800">Stocks From 500-800 Range</option>
  <option value="800,1000">Stocks From 800-1000 Range</option>
  <option value="1000,200000">Stocks above 1000 Range</option>
</select>

<?php }?>


Company name :- <input type="text" id="cname" onkeyup="search_company()">

<br/>
 <br/>

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
            </tr>
        
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datas']->value, 'value', false, NULL, 'count', array (
  'iteration' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_count']->value['iteration']++;
?>




    <tr class="show">
        <td> <?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_count']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_count']->value['iteration'] : null);?>
 </td>    
        <td>
            <a href="edit_stock.php?id=<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['value']->value['notes'];?>
" target="blank"><?php echo $_smarty_tpl->tpl_vars['value']->value['sName'];?>
 [<?php echo $_smarty_tpl->tpl_vars['value']->value['ntype'];?>
]</a>
            <input type="hidden" id="sname" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['sName'];?>
"/> 
            <input type="hidden" id="sid" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"/> 
        </td>
        <td><a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['murl'];?>
" target="_blank">Money Control Link</a></td>
        <td><a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['curl'];?>
" target="_blank">ChartInk</a></td>
        <td><?php echo $_smarty_tpl->tpl_vars['value']->value['currOpen'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['value']->value['currClose'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['value']->value['currHigh'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['value']->value['currLow'];?>
</td>
         <td><?php echo $_smarty_tpl->tpl_vars['value']->value['pChange'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['value']->value['volume'];?>
</td>
        <td><a href="javascript:void(0)" id="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" class="watch" title="watch">WatchList</a></td>
    </tr>


<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>




</table>
</div>
</center><?php }
}
