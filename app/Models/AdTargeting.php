<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdTargeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'geo_country',
        'geo_city',
        'device',
        'os',
        'browser',
        'age_min',
        'age_max',
        'gender',
    ];

    protected $casts = [
        'ad_id' => 'integer',
        'age_min' => 'integer',
        'age_max' => 'integer',
    ];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}
