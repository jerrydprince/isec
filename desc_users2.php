<?php
$dsn = 'mysql:host=localhost;dbname=isec_db;charset=utf8mb4';
$pdo = new PDO($dsn, 'root', '');
$res = $pdo->query('SHOW CREATE TABLE users')->fetch(PDO::FETCH_ASSOC);
echo $res['Create Table'];
