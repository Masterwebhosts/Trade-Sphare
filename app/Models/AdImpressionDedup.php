<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdImpressionDedup extends Model
{
    protected $table = 'ad_impression_dedup';


    protected $fillable = [
        'ad_id',
        'zone_id',
        'fingerprint',
        'last_impression_at',
    ];


    protected $casts = [
        'last_impression_at' => 'datetime',
    ];



    public function ad()
    {
        return $this->belongsTo(
            Ad::class
        );
    }



    public function zone()
    {
        return $this->belongsTo(
            AdZone::class,
            'zone_id'
        );
    }
}