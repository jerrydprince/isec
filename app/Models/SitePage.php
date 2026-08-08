<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class SitePage extends Model {
    protected static string $table = 'dynamic_pages';

    public static function findBySlugPublished(string $slug): ?array {
        $db = static::getDb();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE slug = :slug AND status = 'published' LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}
