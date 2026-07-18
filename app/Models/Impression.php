<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Impression extends Model
{
    use HasFactory;



    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'ad_id',

        'campaign_id',

        'publisher_id',

        'zone_id',

        'ip_address',

        'user_agent',

        'fingerprint',

    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'ad_id' => 'integer',

        'campaign_id' => 'integer',

        'publisher_id' => 'integer',

        'zone_id' => 'integer',

    ];



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function ad(): BelongsTo
    {
        return $this->belongsTo(
            Ad::class,
            'ad_id'
        );
    }



    public function campaign(): BelongsTo
    {
        return $this->belongsTo(
            Campaign::class,
            'campaign_id'
        );
    }



    public function publisher(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'publisher_id'
        );
    }



    public function zone(): BelongsTo
    {
        return $this->belongsTo(
            AdZone::class,
            'zone_id'
        );
    }



    public function clicks(): HasMany
    {
        return $this->hasMany(
            Click::class,
            'impression_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */


    public function hasClicks(): bool
    {
        return $this->clicks()->exists();
    }



    public function isValid(): bool
    {
        return $this->ad_id !== null
            && $this->publisher_id !== null
            && $this->zone_id !== null;
    }
}