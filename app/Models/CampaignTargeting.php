<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignTargeting extends Model
{
    protected $fillable = [
        'campaign_id',
        'scope',
        'governorate_id',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function isAllSyria(): bool
    {
        return $this->scope === 'all_syria';
    }

    public function isGovernorate(): bool
    {
        return $this->scope === 'governorate';
    }
}
