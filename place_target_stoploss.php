<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$output = shell_exec('cd /Users/disingh/Documents/GitHub/kite-karate/  && mvn clean test  -Dkarate.options="classpath:kite/place_order.feature"');

// Display the list of all file
// and directory
echo "<pre>$output</pre>";
?>