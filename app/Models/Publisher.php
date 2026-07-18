<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Publisher extends Model
{
    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'user_id',

        'name',

        'platform',

        'url',

        'type',

    ];



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    /**
     * Owner user account
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }



    /**
     * Publisher zones
     */
    public function zones(): HasMany
    {
        return $this->hasMany(
            AdZone::class
        );
    }



    /**
     * Impressions through zones
     */
    public function impressions(): HasManyThrough
    {
        return $this->hasManyThrough(
            Impression::class,
            AdZone::class,
            'publisher_id',
            'zone_id',
            'user_id',
            'id'
        );
    }



    /**
     * Clicks through zones
     */
    public function clicks(): HasManyThrough
    {
        return $this->hasManyThrough(
            Click::class,
            AdZone::class,
            'publisher_id',
            'zone_id',
            'user_id',
            'id'
        );
    }



    /**
     * Withdrawal requests
     */
    public function withdrawals(): HasMany
    {
        return $this->hasMany(
            Withdrawal::class,
            'publisher_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | WALLET
    |--------------------------------------------------------------------------
    |
    | Wallet belongs to User in current Ledger architecture.
    |
    */

    public function wallet()
    {
        return $this->user?->wallet;
    }



    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isSocial(): bool
    {
        return $this->type === 'social';
    }



    public function isWeb(): bool
    {
        return $this->type === 'web';
    }
}