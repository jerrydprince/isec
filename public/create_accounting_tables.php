<?php
require_once __DIR__ . '/../app/config/config.php';

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // 1. Alter Invoices
    try {
        $pdo->exec("ALTER TABLE `invoices` ADD COLUMN `amount_paid` DECIMAL(15,2) NOT NULL DEFAULT 0.00 AFTER `total_amount`");
    } catch (PDOException $e) { } // Ignore if exists
    
    try {
        $pdo->exec("ALTER TABLE `invoices` ADD COLUMN `balance_due` DECIMAL(15,2) NOT NULL DEFAULT 0.00 AFTER `amount_paid`");
    } catch (PDOException $e) { }

    // Change status from enum to varchar to allow more flexibility
    try {
        $pdo->exec("ALTER TABLE `invoices` MODIFY COLUMN `status` VARCHAR(50) DEFAULT 'Draft'");
    } catch (PDOException $e) { }

    // Set existing paid invoices correctly
    $pdo->exec("UPDATE `invoices` SET `amount_paid` = `total_amount`, `balance_due` = 0 WHERE `status` = 'Paid'");
    // Set existing unpaid invoices correctly
    $pdo->exec("UPDATE `invoices` SET `balance_due` = `total_amount` WHERE `status` IN ('Draft', 'Sent') AND `balance_due` = 0");


    // 2. Create Invoice Payments
    $sqlInvoicePayments = "
    CREATE TABLE IF NOT EXISTS `invoice_payments` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `invoice_id` int(11) NOT NULL,
        `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
        `payment_date` date NOT NULL,
        `payment_method` varchar(50) DEFAULT 'Bank Transfer',
        `reference` varchar(100) DEFAULT NULL,
        `notes` text DEFAULT NULL,
        `created_at` timestamp DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        CONSTRAINT `fk_inv_payments` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    $pdo->exec($sqlInvoicePayments);

    // 3. Create Expenses Table
    $sqlExpenses = "
    CREATE TABLE IF NOT EXISTS `expenses` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `description` text DEFAULT NULL,
        `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
        `expense_date` date NOT NULL,
        `category` varchar(100) DEFAULT 'General',
        `created_at` timestamp DEFAULT current_timestamp(),
        `updated_at` timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    $pdo->exec($sqlExpenses);
    
    echo "<h1>Accounting Tables Setup Successful!</h1><p>You can safely delete this file.</p>";

} catch (PDOException $e) {
    die("<h1>Database Error</h1><p>" . $e->getMessage() . "</p>");
}
