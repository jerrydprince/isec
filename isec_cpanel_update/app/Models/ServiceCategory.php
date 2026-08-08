<?php

namespace App\Models;

use App\Core\Model;

class ServiceCategory extends Model {
    protected static string $table = 'service_categories';

    public function getServices(): array {
        return Service::where('category_id', $this->id);
    }
}
