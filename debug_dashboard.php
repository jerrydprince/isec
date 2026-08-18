<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    echo "Connected to " . DB_NAME . " as " . DB_USER . "\n";
    
    $incomeStmt = $pdo->query("SELECT SUM(amount_paid) as total FROM invoices WHERE status != 'Cancelled'");
    echo "Income from invoices: " . $incomeStmt->fetchColumn() . "\n";
    
    $onlineStmt = $pdo->query("SELECT SUM(amount) as total FROM payments WHERE status = 'success'");
    echo "Income from payments: " . $onlineStmt->fetchColumn() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
