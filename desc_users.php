<?php
require 'app/config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getConnection();
$res = $db->query('SHOW CREATE TABLE users')->fetch(PDO::FETCH_ASSOC);
print_r($res);
