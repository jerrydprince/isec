<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * System Audit Log Entity Model
 */
class AuditLog extends Model {
    protected static string $table = 'audit_logs';

    /**
     * Log a user action to the audit trail
     */
    public static function log(?int $userId, string $action, ?string $details = null): bool {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        try {
            self::create([
                'user_id' => $userId,
                'action' => $action,
                'details' => $details,
                'ip_address' => $ip
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Retrieve all audit logs joined with the respective administrative user's names
     */
    public static function getLogsWithUser(): array {
        $db = self::getDb();
        $sql = "SELECT al.*, u.name as user_name, u.email as user_email 
                FROM `audit_logs` al 
                LEFT JOIN `users` u ON al.user_id = u.id 
                ORDER BY al.id DESC 
                LIMIT 200";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
