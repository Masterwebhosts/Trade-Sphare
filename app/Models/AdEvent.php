<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'publisher_id',
        'zone_id',
        'event_type',
        'meta',
    ];

    protected $casts = [
        'ad_id' => 'integer',
        'publisher_id' => 'integer',
        'zone_id' => 'integer',
        'meta' => 'array',
    ];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(AdZone::class, 'zone_id');
    }
}
