<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Click extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    public function scopeValid($query)
    {
        return $query->where(
            'status',
            'valid'
        );
    }



    public function scopeSuspicious($query)
    {
        return $query->where(
            'status',
            'suspicious'
        );
    }



    public function scopeRejected($query)
    {
        return $query->where(
            'status',
            'rejected'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */


    protected $fillable = [


        'ad_id',

        'publisher_id',
        
         'campaign_id',

        'zone_id',

        'impression_id',

        'ip_address',

        'user_agent',

        'fingerprint',

        'is_fraud',

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

        'impression_id' => 'integer',

        'is_fraud' => 'boolean',

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



    public function impression(): BelongsTo
    {
        return $this->belongsTo(
            Impression::class,
            'impression_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */


    public function isFraud(): bool
    {
        return (bool) $this->is_fraud;
    }



    public function isValid(): bool
    {
        return ! $this->is_fraud;
    }



    public function isChargeable(): bool
    {
        return ! $this->isFraud();
    }
}