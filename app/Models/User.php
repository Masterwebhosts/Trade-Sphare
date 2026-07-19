<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [

        'name',

        'email',

        'password_hash',

        'role',

        'status',

    ];



    protected $hidden = [

        'password_hash',

    ];



    /**
     * Laravel Auth password column override
     */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }



    /**
     * تلقائيًا: عند تعيين password يتم تخزينه في password_hash
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password_hash'] = Hash::make($value);
    }



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function wallet(): MorphOne
    {
        return $this->morphOne(
            Wallet::class,
            'owner'
        );
    }



    public function campaigns(): HasMany
    {
        return $this->hasMany(
            Campaign::class,
            'advertiser_id'
        );
    }



    public function adZones(): HasMany
    {
        return $this->hasMany(
            AdZone::class,
            'publisher_id'
        );
    }



    public function impressions(): HasMany
    {
        return $this->hasMany(
            Impression::class,
            'publisher_id'
        );
    }



    public function clicks(): HasMany
    {
        return $this->hasMany(
            Click::class,
            'publisher_id'
        );
    }



    public function withdrawals(): HasMany
    {
        return $this->hasMany(
            Withdrawal::class,
            'publisher_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | ROLES HELPERS
    |--------------------------------------------------------------------------
    */


    public function isAdvertiser(): bool
    {
        return $this->role === 'advertiser';
    }



    public function isPublisher(): bool
    {
        return $this->role === 'publisher';
    }



    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}