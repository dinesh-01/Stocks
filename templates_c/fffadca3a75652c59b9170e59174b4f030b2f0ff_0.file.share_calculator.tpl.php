<?php
/* Smarty version 3.1.30, created on 2021-07-23 21:24:21
  from "/opt/lampp/htdocs/analytics/views/share_calculator.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_60fb176506fc27_24534684',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fffadca3a75652c59b9170e59174b4f030b2f0ff' => 
    array (
      0 => '/opt/lampp/htdocs/analytics/views/share_calculator.tpl',
      1 => 1478547694,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60fb176506fc27_24534684 (Smarty_Internal_Template $_smarty_tpl) {
?>
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



<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datas']->value, 'value', false, NULL, 'count', array (
  'iteration' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_count']->value['iteration']++;
?>
    

    <tr class="show">
        <td><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_count']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_count']->value['iteration'] : null);?>
</td>    
        <td><?php echo $_smarty_tpl->tpl_vars['value']->value['sName'];?>
<input type="hidden" id="sid" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"/> </td>
        <td><?php echo $_smarty_tpl->tpl_vars['value']->value['symbol'];?>
</td>
        <td><a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['murl'];?>
" target="_blank">Money Control Link</a></td>
        <td><a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['curl'];?>
" target="_blank">ChartInk</a></td>
        <td>  <input type="text" name="qvolume" id="qvolume<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" size="7" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['qvolume'];?>
"
        onkeyup="show_calculator('<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
')" />  </td>
        <td>  <input type="text" name="qbuy" id="qbuy<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" size="5" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['qbuy'];?>
" 
        onkeyup="show_calculator('<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
')" />  </td>
        <td>  <input type="text" name="qtotal" id="qtotal<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" size="7" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['qtotal'];?>
" readonly="readonly" /> </td>
        <td> <input type="button" id="reset<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" value="Clear"  onclick="show_calculator_reset('<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
')" /></td> 
    </tr>

<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


<tr >
    <td colspan="5"><b>All Total</b></td>
    <td colspan="2" ><span id="ttotals"><?php echo $_smarty_tpl->tpl_vars['totals']->value;?>
</span></td>
</tr>



</table>
</div>
</center><?php }
}
