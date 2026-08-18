<?php
$db = new PDO("mysql:host=localhost;dbname=isec_db", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE TABLE IF NOT EXISTS `subscriptions` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `customer_id` BIGINT UNSIGNED NULL,
    `service_name` VARCHAR(255) NOT NULL,
    `provider_platform` VARCHAR(255) NULL,
    `cost` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `billing_cycle` ENUM('Monthly', 'Quarterly', 'Yearly') NOT NULL DEFAULT 'Yearly',
    `start_date` DATE NOT NULL,
    `next_due_date` DATE NOT NULL,
    `status` ENUM('Active', 'Expired', 'Cancelled') NOT NULL DEFAULT 'Active',
    `notify_client` TINYINT(1) NOT NULL DEFAULT 1,
    `notify_office` TINYINT(1) NOT NULL DEFAULT 1,
    `reminders_sent` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

echo "Subscriptions table created locally.\n";
