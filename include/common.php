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
$smarty->force_compile = true;
$smarty->template_dir = 'views';


define('TOKEN', 'CAFVj0oll33JwwudBTjDDV6hpzvsWIXI');
define('KEY', 'asx9hj1ykmv09kgc');
define('ALLOCATE_PRICE',50000);
define('OPTION_MONTH','MAY');
define ('TWILIO_SID','ACfae6d012234d7f7af49afbe88e254447');
define ('TWILIO_TOKEN','b8ce01a7e52e46d86ef3604128d7f9de');





