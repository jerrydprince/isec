<?php
// create_templates_table.php
// Place this in the root directory (same level as public, app, etc.)
require_once __DIR__ . '/app/config/config.php';

try {
    // Determine which database credentials to use based on environment
    $isLocalhost = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || $_SERVER['HTTP_HOST'] === 'localhost';

    if ($isLocalhost) {
        $host = 'localhost';
        $db = 'isec_db';
        $user = 'root';
        $pass = '';
    } else {
        $host = 'localhost';
        $db = 'isecltd1_isecltd_db';
        $user = 'isecltd1_jerry';
        $pass = 'P@ssword123#'; // Ensure this is correct for production
    }

    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    $sql = "CREATE TABLE IF NOT EXISTS `message_templates` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255) NOT NULL,
        `type` ENUM('Email', 'SMS', 'WhatsApp') NOT NULL DEFAULT 'Email',
        `subject` VARCHAR(255) NULL,
        `body` TEXT NOT NULL,
        `variables` TEXT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);
    echo "<h2 style='color: green;'>Success! The `message_templates` table has been created.</h2>";
    echo "<p>You can now delete this file and use the Message Templates feature.</p>";

} catch (PDOException $e) {
    echo "<h2 style='color: red;'>Database Error:</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
