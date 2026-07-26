<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * User Entity Model
 */
class User extends Model {
    protected static string $table = 'users';

    /**
     * Find a user by email, joining their role and retrieving associated permissions
     */
    public static function findByEmail(string $email): ?array {
        $db = self::getDb();
        
        $sql = "SELECT u.*, r.name as role_name 
                FROM `users` u 
                JOIN `roles` r ON u.role_id = r.id 
                WHERE u.email = :email LIMIT 1";
                
        $stmt = $db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Load permissions
            $permSql = "SELECT p.name 
                        FROM `role_permissions` rp 
                        JOIN `permissions` p ON rp.permission_id = p.id 
                        WHERE rp.role_id = :role_id";
            $permStmt = $db->prepare($permSql);
            $permStmt->execute(['role_id' => $user['role_id']]);
            $user['permissions'] = $permStmt->fetchAll(PDO::FETCH_COLUMN);
        }
        
        return $user ?: null;
    }
}
