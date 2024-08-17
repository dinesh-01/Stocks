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
require_once 'kite_function.php';

//Adding smarty template
require_once 'smarty/libs/Smarty.class.php';
$smarty = new Smarty();
$smarty->force_compile = true;
$smarty->template_dir = 'views';


define('TOKEN', 'x');
define('KEY', 'x');
define('ALLOCATE_PRICE',100000);
define('TIME_FRAME',15);

define('EXPIRY_ALLOCATE_PRICE',10000);
define('OPTION_MONTH','AUG');





