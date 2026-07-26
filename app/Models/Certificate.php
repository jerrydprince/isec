<?php

namespace App\Models;

use App\Core\Model;

/**
 * Trainee Certificate Entity Model
 */
class Certificate extends Model {
    protected static string $table = 'certificates';

    /**
     * Find a certificate by its unique registration number
     */
    public static function findByNumber(string $certificateNumber): ?array {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT * FROM `certificates` WHERE TRIM(`certificate_number`) = :number LIMIT 1");
        $stmt->execute(['number' => trim($certificateNumber)]);
        $cert = $stmt->fetch();
        return $cert ?: null;
    }
}
