<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdServe extends Model
{
    protected $fillable = [
        'ad_id',
        'campaign_id',
        'token',
        'cpc',
        'clicked',
        'expires_at',
    ];

    protected $casts = [
        'clicked' => 'boolean',
        'expires_at' => 'datetime',
        'cpc' => 'float',
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isClicked(): bool
    {
        return (bool) $this->clicked;
    }
}