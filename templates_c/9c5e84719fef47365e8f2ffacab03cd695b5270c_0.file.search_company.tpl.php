<?php
/* Smarty version 3.1.30, created on 2021-07-24 11:04:55
  from "/var/www/html/analytics/views/search_company.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_60fbf3d745b3d8_21616124',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c5e84719fef47365e8f2ffacab03cd695b5270c' => 
    array (
      0 => '/var/www/html/analytics/views/search_company.tpl',
      1 => 1478547694,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60fbf3d745b3d8_21616124 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 src="js/search_company.js"><?php echo '</script'; ?>
>

<br/>
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
