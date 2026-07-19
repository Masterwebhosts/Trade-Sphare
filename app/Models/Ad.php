<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ad extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    public const STATUS_DRAFT    = 'draft';
    public const STATUS_PENDING  = 'pending_review';
    public const STATUS_ACTIVE   = 'active';
    public const STATUS_PAUSED   = 'paused';
    public const STATUS_REJECTED = 'rejected';



    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'campaign_id',
        'title',
        'description',
        'content_type',
        'media_url',
        'target_url',
        'status',
    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'campaign_id' => 'integer',
    ];



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function campaign(): BelongsTo
    {
        return $this->belongsTo(
            Campaign::class,
            'campaign_id'
        );
    }


    public function zones(): BelongsToMany
    {
        return $this->belongsToMany(
            AdZone::class,
            'ad_zone_ads',
            'ad_id',
            'ad_zone_id'
        );
    }


    public function impressions(): HasMany
    {
        return $this->hasMany(
            Impression::class,
            'ad_id'
        );
    }


    public function clicks(): HasMany
    {
        return $this->hasMany(
            Click::class,
            'ad_id'
        );
    }


    public function adServes(): HasMany
    {
        return $this->hasMany(
            AdServe::class,
            'ad_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TARGETING / REVIEWS / EVENTS
    |--------------------------------------------------------------------------
    */


    public function targetings(): HasMany
    {
        return $this->hasMany(
            AdTargeting::class,
            'ad_id'
        );
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(
            AdReview::class,
            'ad_id'
        );
    }


    public function events(): HasMany
    {
        return $this->hasMany(
            AdEvent::class,
            'ad_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | OWNER
    |--------------------------------------------------------------------------
    */


    public function getUserAttribute()
    {
        return $this->campaign?->advertiser;
    }


    public function advertiser()
    {
        return $this->campaign?->advertiser;
    }



    /*
    |--------------------------------------------------------------------------
    | BUSINESS LOGIC
    |--------------------------------------------------------------------------
    */


    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }


    public function canBeServed(): bool
    {
        return
            $this->isActive()
            &&
            $this->campaign
            &&
            $this->campaign->canServeAds();
    }


    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }



    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    public function scopeActive($query)
    {
        return $query->where(
            'status',
            self::STATUS_ACTIVE
        );
    }


    public function scopeServeable($query)
    {
        return $query
            ->where(
                'status',
                self::STATUS_ACTIVE
            )
            ->whereHas(
                'campaign',
                function ($q) {

                    $q->where(
                        'status',
                        Campaign::STATUS_APPROVED
                    );

                }
            );
    }


    public function scopeEligible($query)
    {
        return $query->serveable();
    }
}