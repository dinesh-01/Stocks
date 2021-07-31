<?php
/* Smarty version 3.1.30, created on 2021-07-24 08:52:08
  from "/var/www/html/analytics/views/list_watch.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_60fbd4b8a49680_96476978',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e5042047f55d77f0dfdd8492a2ace3855e2b30ab' => 
    array (
      0 => '/var/www/html/analytics/views/list_watch.tpl',
      1 => 1478547694,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60fbd4b8a49680_96476978 (Smarty_Internal_Template $_smarty_tpl) {
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
