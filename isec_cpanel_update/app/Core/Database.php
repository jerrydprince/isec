<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * PDO Database Manager (Singleton Connection)
 */
class Database {
    private static ?PDO $pdo = null;

    /**
     * Get or create PDO Database Connection
     */
    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                self::$pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                // Return clear instructions if DB connection fails
                die("<h3>Database Connection Error</h3><p>Could not connect to database <strong>" . DB_NAME . "</strong>. Check config settings and verify XAMPP MySQL is active.</p><p>Error: " . $e->getMessage() . "</p>");
            }
        }
        return self::$pdo;
    }
}
