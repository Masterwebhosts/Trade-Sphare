<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdClickDedup extends Model
{
    use HasFactory;



    protected $table = 'ad_click_dedup';



    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'ad_id',

        'zone_id',

        'fingerprint',

        'last_click_at',

    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'last_click_at' => 'datetime',

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
            'zone_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */


    public function isExpired(
        int $minutes = 10
    ): bool {

        if (! $this->last_click_at) {

            return true;

        }


        return $this->last_click_at
            ->lt(
                now()->subMinutes($minutes)
            );
    }



    public function touchClick(): void
    {
        $this->update([

            'last_click_at' => now(),

        ]);
    }
}