<?php
require 'app/config/config.php';
require 'app/Core/Database.php';
require 'app/Models/Payment.php';

$db = \App\Models\Payment::getDB();

try {
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
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            
            $db->exec("CREATE TABLE IF NOT EXISTS `project_tasks` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `project_id` BIGINT UNSIGNED NOT NULL,
                `title` VARCHAR(255) NOT NULL,
                `description` TEXT NULL,
                `status` ENUM('To Do', 'In Progress', 'In Review', 'Completed') NOT NULL DEFAULT 'To Do',
                `priority` ENUM('Low', 'Medium', 'High', 'Urgent') NOT NULL DEFAULT 'Medium',
                `due_date` DATE NULL,
                `assigned_to` INT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`assigned_to`) REFERENCES `users`(`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

            $db->exec("CREATE TABLE IF NOT EXISTS `project_time_logs` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `project_id` BIGINT UNSIGNED NOT NULL,
                `task_id` BIGINT UNSIGNED NULL,
                `user_id` INT NOT NULL,
                `hours` DECIMAL(5,2) NOT NULL,
                `date_logged` DATE NOT NULL,
                `notes` TEXT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`task_id`) REFERENCES `project_tasks`(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

            $db->exec("CREATE TABLE IF NOT EXISTS `project_files` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `project_id` BIGINT UNSIGNED NOT NULL,
                `file_name` VARCHAR(255) NOT NULL,
                `file_path` VARCHAR(255) NOT NULL,
                `file_size` BIGINT UNSIGNED NOT NULL DEFAULT 0,
                `uploaded_by` INT NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`uploaded_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

            try {
                $db->exec("ALTER TABLE `invoices` ADD COLUMN `project_id` BIGINT UNSIGNED NULL AFTER `customer_id`");
                $db->exec("ALTER TABLE `invoices` ADD CONSTRAINT `fk_invoice_project` FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE SET NULL");
            } catch (\PDOException $e) {
                // Ignore if column already exists
            }
            
            echo "Success\n";
} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
