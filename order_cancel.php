<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$output = shell_exec('cd /Users/disingh/Documents/GitHub/kite-karate/  && mvn clean test  -Dkarate.options="classpath:kite/place_cancel_order.feature"');


echo "<pre>";
echo $output;
echo "</pre>";

/*
function string_between_two_string($str, $starting_word, $ending_word)
{
    $arr = explode($starting_word, $str);
    if (isset($arr[1])) {
        $arr = explode($ending_word, $arr[1]);
        return $arr[0];
    }
    return '';
}

$start = "extractstart";
$end = "extractstop";
$substring = string_between_two_string($output, $start, $end);

echo "<pre>";
echo $substring;
echo "</pre>";
*/
?>