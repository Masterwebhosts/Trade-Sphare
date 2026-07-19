<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Wallet extends Model
{
    protected $fillable = [

        'owner_id',

        'owner_type',

        'currency',

        'status',

    ];



    protected $casts = [

        'owner_id' => 'integer',

    ];



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function owner(): MorphTo
    {
        return $this->morphTo();
    }



    public function transactions(): HasMany
    {
        return $this->hasMany(
            WalletTransaction::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | BALANCE
    |--------------------------------------------------------------------------
    |
    | Calculated from approved wallet transactions.
    |
    */


    public function getBalanceAttribute(): float
    {
        return $this->calculateBalance();
    }



    public function calculateBalance(): float
    {
        $credits = $this->transactions()
            ->where(
                'direction',
                WalletTransaction::DIRECTION_CREDIT
            )
            ->where(
                'status',
                WalletTransaction::STATUS_APPROVED
            )
            ->sum('amount');



        $debits = $this->transactions()
            ->where(
                'direction',
                WalletTransaction::DIRECTION_DEBIT
            )
            ->where(
                'status',
                WalletTransaction::STATUS_APPROVED
            )
            ->sum('amount');



        return round(
            (float) $credits - (float) $debits,
            2
        );
    }



    /*
    |--------------------------------------------------------------------------
    | FACTORY HELPER
    |--------------------------------------------------------------------------
    */


    public static function forUser($user): ?self
    {
        return self::query()
            ->where(
                'owner_id',
                $user->id
            )
            ->where(
                'owner_type',
                $user::class
            )
            ->first();
    }



    /*
    |--------------------------------------------------------------------------
    | STATE HELPERS
    |--------------------------------------------------------------------------
    */


    public function hasBalance(float $amount): bool
    {
        return $this->calculateBalance() >= $amount;
    }
}