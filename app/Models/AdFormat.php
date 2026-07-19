<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdFormat extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'code',
        'size',
        'description',
        'status',
        'supports_video',
        'supports_image',
        'max_assets',
    ];


    protected $casts = [
        'supports_video' => 'boolean',
        'supports_image' => 'boolean',
        'max_assets' => 'integer',
    ];
}