<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Campaign extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING  = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_PAUSED   = 'paused';
    public const STATUS_COMPLETED = 'completed';



    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'advertiser_id',

        'governorate_id',

        'title',

        'description',

        'budget_total',

        'budget_spent',

        'budget_remaining',

        'cpc',

        'start_date',

        'end_date',

        'status',

    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'budget_total'     => 'decimal:6',

        'budget_spent'     => 'decimal:6',

        'budget_remaining' => 'decimal:6',

        'cpc'              => 'decimal:6',

        'start_date'       => 'date',

        'end_date'         => 'date',

    ];



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function ads(): HasMany
    {
        return $this->hasMany(
            Ad::class
        );
    }



    public function advertiser(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'advertiser_id'
        );
    }



    public function targetings(): HasManyThrough
    {
        return $this->hasManyThrough(
            AdTargeting::class,
            Ad::class,
            'campaign_id',
            'ad_id',
            'id',
            'id'
        );
    }



    public function impressions(): HasMany
    {
        return $this->hasMany(
            Impression::class
        );
    }



    public function clicks(): HasMany
    {
        return $this->hasMany(
            Click::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */


    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }



    public function canServeAds(): bool
    {

        if (! $this->isApproved()) {

            return false;

        }


        if (
    $this->start_date &&
    today()->lt($this->start_date)
) {

    return false;

}


        if (
            $this->end_date &&
            now()->gt($this->end_date)
        ) {

            return false;

        }


        return $this->hasBudget();

    }



    /*
    |--------------------------------------------------------------------------
    | BUDGET
    |--------------------------------------------------------------------------
    */


    public function getSpentAttribute(): string
    {
        return (string) $this->budget_spent;
    }



    public function getRemainingAttribute(): string
    {
        return max(
            '0',
            (string) $this->budget_remaining
        );
    }



    public function hasBudget(): bool
    {
        return bccomp(
            $this->remaining,
            (string) $this->cpc,
            6
        ) >= 0;
    }



    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    public function scopeApproved($query)
    {
        return $query->where(
            'status',
            self::STATUS_APPROVED
        );
    }



    public function scopeRunning($query)
    {
        return $query

            ->where(
                'status',
                self::STATUS_APPROVED
            )

            ->where(function ($q) {

                $q
                    ->whereNull('start_date')
                    ->orWhere(
                        'start_date',
                        '<=',
                        now()
                    );

            })

            ->where(function ($q) {

                $q
                    ->whereNull('end_date')
                    ->orWhere(
                        'end_date',
                        '>=',
                        now()
                    );

            });
    }
}