<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PublisherEarningDaily extends Model
{
    use HasFactory;



    protected $table = 'publisher_earning_dailies';



    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'publisher_id',

        'ad_id',

        'ad_zone_id',

        'campaign_id',

        'date',

        'clicks',

        'earnings',

    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'date' => 'date',

        'clicks' => 'integer',

        'earnings' => 'decimal:6',

    ];



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function publisher(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'publisher_id'
        );
    }



    public function ad(): BelongsTo
    {
        return $this->belongsTo(
            Ad::class,
            'ad_id'
        );
    }



    public function zone(): BelongsTo
    {
        return $this->belongsTo(
            AdZone::class,
            'ad_zone_id'
        );
    }



    public function campaign(): BelongsTo
    {
        return $this->belongsTo(
            Campaign::class,
            'campaign_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */


    public function addClicks(
        int $count = 1
    ): void {

        $this->increment(
            'clicks',
            $count
        );

    }



    public function addEarning(
        float $amount
    ): void {

        $this->increment(
            'earnings',
            $amount
        );

    }



    public function recordClick(
        float $amount
    ): void {

        $this->increment(
            'clicks'
        );

        $this->increment(
            'earnings',
            $amount
        );

    }
}