<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $fillable = [
        'user_name',
        'model_type',
        'model_id',
        'action',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent'
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
        ];
    }
}
