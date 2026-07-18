<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'withdrawal_requests';



    /*
    |--------------------------------------------------------------------------
    | STATUS CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_PAID = 'paid';



    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'publisher_id',

        'wallet_id',

        'amount',

        'status',

        'iban',

        'bank_name',

        'admin_id',

        'processed_at',

    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'amount' => 'decimal:2',

        'processed_at' => 'datetime',

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



    public function publisher(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'publisher_id'
        );
    }



    public function admin(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'admin_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | COMPATIBILITY
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->publisher;
    }



    /*
    |--------------------------------------------------------------------------
    | STATUS HELPERS
    |--------------------------------------------------------------------------
    */

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }



    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }



    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }



    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }
}