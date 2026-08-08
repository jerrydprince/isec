<?php

namespace App\Models;

use App\Core\Model;

/**
 * Key-Value Site Settings Model
 */
class Settings extends Model {
    protected static string $table = 'settings';
    
    // In-memory key-value cache
    private static array $cache = [];

    /**
     * Get a setting by key
     */
    public static function get(string $key, ?string $default = null): ?string {
        if (array_key_exists($key, self::$cache)) {
            return self::$cache[$key];
        }
        
        $db = self::getDb();
        $stmt = $db->prepare("SELECT `value` FROM `settings` WHERE `key` = :key LIMIT 1");
        $stmt->execute(['key' => $key]);
        $row = $stmt->fetch();
        
        if ($row) {
            self::$cache[$key] = $row['value'];
            return $row['value'];
        }
        
        return $default;
    }

    /**
     * Set/Update a setting value
     */
    public static function set(string $key, ?string $value): bool {
        self::$cache[$key] = $value;
        $db = self::getDb();
        
        $stmt = $db->prepare("SELECT `id` FROM `settings` WHERE `key` = :key LIMIT 1");
        $stmt->execute(['key' => $key]);
        $exists = $stmt->fetch();
        
        if ($exists) {
            $updateStmt = $db->prepare("UPDATE `settings` SET `value` = :value WHERE `key` = :key");
            return $updateStmt->execute(['value' => $value, 'key' => $key]);
        } else {
            $insertStmt = $db->prepare("INSERT INTO `settings` (`key`, `value`) VALUES (:key, :value)");
            return $insertStmt->execute(['key' => $key, 'value' => $value]);
        }
    }
}
