<?php
 #session_start();
 //Disable Error Warning
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

date_default_timezone_set("Asia/Calcutta");


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
$smarty->caching = false;
$smarty->force_compile - false;
$smarty->template_dir = 'views';


define('TOKEN', 'ev5Ffid6dwHJiAC5DhAQ4ZVDeRd3T5p3');
define('KEY', 'asx9hj1ykmv09kgc');
define('ALLOCATE_PRICE',100000);
define('OPTION_MONTH','MAR');





