<?php
/* Smarty version 3.1.30, created on 2021-07-23 21:41:33
  from "/opt/lampp/htdocs/analytics/views/show_watch_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_60fb1b6d5ae0e2_06592930',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7dca2be58003c9eb8cf1ad67daf8e5fc7098cf92' => 
    array (
      0 => '/opt/lampp/htdocs/analytics/views/show_watch_list.tpl',
      1 => 1627069279,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60fb1b6d5ae0e2_06592930 (Smarty_Internal_Template $_smarty_tpl) {
?>

<link rel = "stylesheet" type = "text/css" href = "css/show_watch_list.css" />
<?php echo '<script'; ?>
 src="js/show_watch_list.js"><?php echo '</script'; ?>
>


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
" class="unwatch" title="unwatch">UnWatch</a></td>
        <td>
           <select name="pri" id="pri<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" onchange="change_priority('<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
');">
            <option value="1" <?php if ($_smarty_tpl->tpl_vars['value']->value['priority'] == 1) {?>   selected="selected"  <?php }?>> 1 </option>
            <option value="2" <?php if ($_smarty_tpl->tpl_vars['value']->value['priority'] == 2) {?>   selected="selected"  <?php }?>> 2 </option>
            <option value="3" <?php if ($_smarty_tpl->tpl_vars['value']->value['priority'] == 3) {?>   selected="selected"  <?php }?>> 3 </option>
           </select>
        </td>
    </tr>


<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>




</table>
</div>
</center>
<?php }
}
