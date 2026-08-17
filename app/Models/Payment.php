<?php

namespace App\Models;

use App\Core\Model;

/**
 * Payment Entity Model
 */
class Payment extends Model {
    protected static string $table = 'payments';
    
    /**
     * Find a payment by its transaction reference
     */
    public static function findByReference(string $reference): ?array {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE reference = :ref");
        $stmt->execute(['ref' => $reference]);
        return $stmt->fetch() ?: null;
    }
}
