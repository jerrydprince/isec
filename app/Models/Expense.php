<?php

namespace App\Models;

use App\Core\Model;

class Expense extends Model {
    protected static string $table = 'expenses';
    protected static array $fillable = [
        'title',
        'description',
        'amount',
        'expense_date',
        'category'
    ];
}
