<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * Blog and Insights Entity Model
 */
class Blog extends Model {
    protected static string $table = 'blogs';

    /**
     * Get single published insight/post by its slug, joining author and category
     */
    public static function getBySlugWithDetails(string $slug): ?array {
        $db = self::getDb();
        $sql = "SELECT b.*, bc.name as category_name, bc.slug as category_slug, u.name as author_name 
                FROM `blogs` b 
                JOIN `blog_categories` bc ON b.category_id = bc.id 
                JOIN `users` u ON b.author_id = u.id 
                WHERE b.slug = :slug LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Get all published insights, optionally filtered by type (blog, case-study, whitepaper) or category slug
     */
    public static function getAllPublished(?string $type = null, ?string $categorySlug = null): array {
        $db = self::getDb();
        $sql = "SELECT b.*, bc.name as category_name, bc.slug as category_slug, u.name as author_name 
                FROM `blogs` b 
                JOIN `blog_categories` bc ON b.category_id = bc.id 
                JOIN `users` u ON b.author_id = u.id 
                WHERE b.status = 'published'";
        
        $params = [];
        if ($type) {
            $sql .= " AND b.type = :type";
            $params['type'] = $type;
        }
        if ($categorySlug) {
            $sql .= " AND bc.slug = :cat_slug";
            $params['cat_slug'] = $categorySlug;
        }
        
        $sql .= " ORDER BY b.published_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
