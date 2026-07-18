<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



/**
 * Deprecated model.
 *
 * Fraud tracking moved to:
 *
 * Click
 *   |
 * FraudDetectionService
 *
 * Keep this model only for legacy records.
 */
class LedgerEntry extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'ad_events';



    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'ad_id',

        'ad_zone_id',

        'event_type',

        'ip',

        'user_agent',

        'device_hash',

        'is_fraud',

        'fraud_score',

        'processed_at',

    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'is_fraud' => 'boolean',

        'fraud_score' => 'integer',

        'processed_at' => 'datetime',

    ];



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function ad(): BelongsTo
    {
        return $this->belongsTo(
            Ad::class
        );
    }



    public function zone(): BelongsTo
    {
        return $this->belongsTo(
            AdZone::class,
            'ad_zone_id'
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


    public function isProcessed(): bool
    {
        return $this->processed_at !== null;
    }
}