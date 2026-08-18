<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'app/config/config.php';
require 'app/Core/Database.php';

$db = \App\Core\Database::getConnection();
$db->exec("DROP TABLE IF EXISTS project_files, project_time_logs, project_tasks, projects");

// Create projects locally to match exactly what is expected
$db->exec("CREATE TABLE IF NOT EXISTS `projects` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `customer_id` BIGINT UNSIGNED NULL,
    `status` ENUM('Not Started', 'In Progress', 'On Hold', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Not Started',
    `start_date` DATE NULL,
    `due_date` DATE NULL,
    `budget` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
echo "Dropped and recreated projects table.";
