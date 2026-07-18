<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdFormat extends Model
{
    protected $fillable = [
        'name',
        'type',
        'width',
        'height',
    ];
}