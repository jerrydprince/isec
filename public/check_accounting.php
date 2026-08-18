<?php
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/Core/Database.php';

try {
    $db = \App\Core\Database::getConnection();
    
    $incomeStmt = $db->query("SELECT SUM(CASE WHEN amount_paid > 0 THEN amount_paid WHEN status = 'Paid' THEN total_amount ELSE 0 END) as total FROM invoices WHERE status != 'Cancelled'");
    $totalIncome = (float)($incomeStmt->fetchColumn() ?: 0);
    
    $onlineStmt = $db->query("SELECT SUM(amount) as total FROM payments WHERE status = 'success'");
    $onlineIncome = (float)($onlineStmt->fetchColumn() ?: 0);
    
    $rawInvoices = $db->query("SELECT id, amount_paid, status, total_amount FROM invoices")->fetchAll();
    $rawPayments = $db->query("SELECT id, amount FROM payments")->fetchAll();
    
    echo "Total Income from Invoices: $totalIncome\n";
    echo "Total Income from Payments: $onlineIncome\n";
    echo "Combined: " . ($totalIncome + $onlineIncome) . "\n";
    echo "Raw Invoices: " . print_r($rawInvoices, true) . "\n";
    echo "Raw Payments: " . print_r($rawPayments, true) . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
