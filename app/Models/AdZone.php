<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class AdZone extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    public const STATUS_ACTIVE  = 'active';
    public const STATUS_PAUSED  = 'paused';
    public const STATUS_PENDING = 'pending';



    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'publisher_id',

        'name',

        'zone_type',

        'governorate_id',

        'token',

        'status',

    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'publisher_id'   => 'integer',

        'governorate_id' => 'integer',

    ];

   /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    /**
     * مالك المنطقة الإعلانية
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'publisher_id'
        );
    }

    /**
     * المحافظة المستهدفة
     */
    public function governorate(): BelongsTo
    {
        return $this->belongsTo(
            Governorate::class,
            'governorate_id'
        );
    }

    public function ads(): BelongsToMany
{
    return $this->belongsToMany(
        Ad::class,
        'ad_zone_ads',
        'ad_zone_id',
        'ad_id'
    );
}

    /**
     * مرات الظهور
     */
    public function impressions(): HasMany
    {
        return $this->hasMany(
            Impression::class,
            'zone_id'
        );
    }

    /**
     * النقرات
     */
    public function clicks(): HasMany
    {
        return $this->hasMany(
            Click::class,
            'zone_id'
        );
    }
    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isPaused(): bool
    {
        return $this->status === self::STATUS_PAUSED;
    }

    public function isServeable(): bool
    {
        return
    $this->isActive()
    && filled($this->token)
    && $this->publisher()->exists();
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
    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getEmbedUrlAttribute(): string
    {
        return url(
            "/embed/zones/{$this->token}"
        );
    }

    public function getServeUrlAttribute(): string
    {
        return url(
            "/api/zones/{$this->token}/serve"
        );
    }
}