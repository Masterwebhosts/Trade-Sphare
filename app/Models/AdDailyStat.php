<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Deprecated.
 *
 * Daily statistics are currently calculated
 * from impressions and clicks tables.
 *
 * Keep this model until reporting aggregation
 * is implemented.
 */
class AdDailyStat extends Model
{
    use HasFactory;



    protected $table = 'ad_daily_stats';



    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'ad_id',

        'date',

        'impressions',

        'clicks',

        'ctr',

    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'date' => 'date',

        'impressions' => 'integer',

        'clicks' => 'integer',

        'ctr' => 'decimal:2',

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



    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */


    public function calculateCtr(): float
    {
        if ($this->impressions <= 0) {

            return 0.0;

        }


        return round(
            ($this->clicks / $this->impressions) * 100,
            2
        );
    }



    public function refreshCtr(): void
    {
        $this->update([

            'ctr' => $this->calculateCtr(),

        ]);
    }
}