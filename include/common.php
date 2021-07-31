<?php
 #session_start();
 //Disable Error Warning
 //error_reporting(0);

//including common files
  require_once 'vendor/autoload.php';
  require_once 'connection.php';
  require_once 'query.php';
  require_once 'sub_query.php';
  require_once 'function.php';
  require_once 'pattern_function.php';

//Adding smarty template
require_once 'smarty/libs/Smarty.class.php';
$smarty = new Smarty();
$smarty->template_dir = 'views';
