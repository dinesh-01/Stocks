<?php

require_once './include/common.php';


function timestamptest()
{
    $t=time();
    echo($t);
}

$maxThreads = 5;
echo 'Example of the multi-thread manager with ' . $maxThreads . ' threads' . PHP_EOL . PHP_EOL;
$params = timestamptest();
$exampleTask = new Threading\Task\Example($params);
$multithreadManager = new Threading\Multiple();

$cpt = 0;
while (++$cpt <= 30)
{
    $multithreadManager->start($exampleTask);
}

?>