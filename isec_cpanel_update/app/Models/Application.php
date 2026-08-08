<?php

namespace App\Models;

use App\Core\Model;

/**
 * Job Candidate Application Entity Model
 */
class Application extends Model {
    protected static string $table = 'applications';

    /**
     * Get all applications joined with vacancy titles
     */
    public static function getApplicationsWithJobs(): array {
        $db = self::getDb();
        $sql = "SELECT a.*, j.title as job_title 
                FROM `applications` a 
                JOIN `jobs` j ON a.job_id = j.id 
                ORDER BY a.id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
