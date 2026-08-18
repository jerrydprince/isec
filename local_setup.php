<?php
$db = new PDO("mysql:host=localhost;dbname=isec_db", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE TABLE IF NOT EXISTS `customers` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `phone` VARCHAR(50) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

$db->exec("CREATE TABLE IF NOT EXISTS `campaigns` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `type` ENUM('Email', 'SMS', 'WhatsApp') NOT NULL,
    `subject` VARCHAR(255) NULL,
    `message` TEXT NOT NULL,
    `status` ENUM('Pending', 'Sent', 'Failed') NOT NULL DEFAULT 'Sent',
    `sent_by` INT NULL,
    `sent_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

echo "Local CRM tables created successfully.\n";
