<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LedgerEntry extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'ledger_entries';



    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'wallet_id',

        'direction',

        'amount',

        'source_type',

        'source_id',

        'balance_after',

    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'wallet_id' => 'integer',

        'amount' => 'decimal:2',

        'source_id' => 'integer',

        'balance_after' => 'decimal:2',

    ];



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function wallet(): BelongsTo
    {
        return $this->belongsTo(
            Wallet::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */


    public function isCredit(): bool
    {
        return $this->direction === WalletTransaction::DIRECTION_CREDIT;
    }



    public function isDebit(): bool
    {
        return $this->direction === WalletTransaction::DIRECTION_DEBIT;
    }
}