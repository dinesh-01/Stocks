<?php
require_once './include/common.php';

// setting up end headers
$headers = [
    'Content-Type' => 'application/json',
    'X-Kite-Version' => '3',
    'Authorization' => 'token '.KEY.':'.TOKEN
];

$client = new GuzzleHttp\Client([
    'headers' => $headers
]);


//Fetching stock Symbol
$id = $_GET['id'];


$query = "DELETE from optionAmo where id='$id'";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);


header("location:stock_options_execution.php");
exit;













?>
