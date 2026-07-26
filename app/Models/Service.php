<?php

namespace App\Models;

use App\Core\Model;

/**
 * Service Entity Model
 */
class Service extends Model {
    protected static string $table = 'services';
    
    /**
     * Retrieve only published services
     */
    public static function getPublished(): array {
        return self::where('status', 'published');
    }
}
