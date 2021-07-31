<?php
/* Smarty version 3.1.30, created on 2016-11-04 09:34:18
  from "C:\xampp\htdocs\analytics\views\list_watch.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_581c480a620a39_97112715',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f36c80edc8731f3ddc9c94bfeb3e778e33f28289' => 
    array (
      0 => 'C:\\xampp\\htdocs\\analytics\\views\\list_watch.tpl',
      1 => 1478248362,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_581c480a620a39_97112715 (Smarty_Internal_Template $_smarty_tpl) {
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
