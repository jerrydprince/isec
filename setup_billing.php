<?php
require_once __DIR__ . '/app/config/config.php';

try {
    $dsn = "mysql:host=localhost;dbname=isec_db;charset=utf8mb4";
    $pdo = new PDO($dsn, "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $sqlInvoices = "
    CREATE TABLE IF NOT EXISTS `invoices` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `invoice_number` varchar(50) NOT NULL,
        `client_name` varchar(150) NOT NULL,
        `client_email` varchar(150) DEFAULT NULL,
        `client_address` text DEFAULT NULL,
        `currency_code` varchar(10) DEFAULT 'NGN',
        `currency_symbol` varchar(10) DEFAULT '₦',
        `issue_date` date NOT NULL,
        `due_date` date DEFAULT NULL,
        `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
        `tax_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
        `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
        `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
        `notes` text DEFAULT NULL,
        `status` enum('Draft','Sent','Paid','Cancelled') DEFAULT 'Draft',
        `payment_date` datetime DEFAULT NULL,
        `payment_method` varchar(50) DEFAULT NULL,
        `created_at` timestamp DEFAULT current_timestamp(),
        `updated_at` timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `idx_invoice_number` (`invoice_number`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $sqlItems = "
    CREATE TABLE IF NOT EXISTS `invoice_items` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `invoice_id` int(11) NOT NULL,
        `description` varchar(255) NOT NULL,
        `quantity` decimal(10,2) NOT NULL DEFAULT 1.00,
        `unit_price` decimal(15,2) NOT NULL DEFAULT 0.00,
        `total` decimal(15,2) NOT NULL DEFAULT 0.00,
        PRIMARY KEY (`id`),
        CONSTRAINT `fk_invoice_items_invoice` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $pdo->exec($sqlInvoices);
    $pdo->exec($sqlItems);
    echo "Tables created successfully.\n";

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage() . "\n");
}
