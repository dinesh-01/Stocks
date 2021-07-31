<?php
require_once './include/common.php';
$query = $queryBuilder->select('id', 'Csymbol')->from('stocklist');
format($query->executeQuery()->fetchOne());