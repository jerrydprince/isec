<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * Project Entity Model
 */
class Project extends Model {
    protected static string $table = 'projects';

    /**
     * Get a project by its slug, joining its category name
     */
    public static function getBySlugWithCategory(string $slug): ?array {
        $db = self::getDb();
        $sql = "SELECT p.*, pc.name as category_name, pc.slug as category_slug 
                FROM `projects` p 
                JOIN `project_categories` pc ON p.category_id = pc.id 
                WHERE p.slug = :slug LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Get all published projects, optionally filtered by category slug
     */
    public static function getAllPublished(?string $categorySlug = null): array {
        $db = self::getDb();
        $sql = "SELECT p.*, pc.name as category_name, pc.slug as category_slug 
                FROM `projects` p 
                JOIN `project_categories` pc ON p.category_id = pc.id 
                WHERE p.status = 'published'";
        
        $params = [];
        if ($categorySlug) {
            $sql .= " AND pc.slug = :cat_slug";
            $params['cat_slug'] = $categorySlug;
        }
        
        $sql .= " ORDER BY p.id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Get all projects (published or draft), joining category details
     */
    public static function getAllProjectsWithCategory(): array {
        $db = self::getDb();
        $sql = "SELECT p.*, pc.name as category_name, pc.slug as category_slug 
                FROM `projects` p 
                JOIN `project_categories` pc ON p.category_id = pc.id 
                ORDER BY p.id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
