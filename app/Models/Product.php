<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'price',
        'currency',
        'is_subscription',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_subscription' => 'boolean',
        'is_active' => 'boolean',
    ];
}