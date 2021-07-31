<?php
/* Smarty version 3.1.30, created on 2021-07-23 21:22:57
  from "/opt/lampp/htdocs/analytics/views/list_watch.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_60fb17113220e0_24651156',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '357ee27bf69499147ff7aecd55e0d225b4404b5c' => 
    array (
      0 => '/opt/lampp/htdocs/analytics/views/list_watch.tpl',
      1 => 1478547694,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60fb17113220e0_24651156 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">

$( document ).ready(function() {
    show_watch_list();
});

<?php echo '</script'; ?>
>

<br/>
<center>

<!--
<table class="gridtable">
<tr>
    <th>
       <select name="type" id="type" onchange="show_watch_list();">
<!--       <option value="penny" > -- Penny Lists -- </option>  
         <option value="nifty" selected="selected" > -- Nifty Lists -- </option>
       </select>
   </th>
</tr>
</table>
<br/>
-->

<div id = "show_result"></div>
<?php }
}
