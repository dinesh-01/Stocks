<?php
use Doctrine\DBAL\DriverManager;

$host_name = "stock-database";
//$host_name = "127.0.0.1:3306";

$connectionParams = array(
    'dbname' => 'analytics',
    'user' => 'root',
    'password' => 'tiger',
    'host' => $host_name,
    'driver' => 'pdo_mysql',
);

$conn = DriverManager::getConnection($connectionParams);
$queryBuilder = $conn->createQueryBuilder();

?>
