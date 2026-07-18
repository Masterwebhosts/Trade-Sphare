<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'wallet_id',
        'type',
        'category',
        'amount',
        'direction',
        'status',
        'reference_type',
        'reference_id',
        'meta',
    ];



    /*
    |--------------------------------------------------------------------------
    | DEFAULT VALUES
    |--------------------------------------------------------------------------
    */

    protected $attributes = [
        'category' => self::CATEGORY_GENERAL,
        'status'   => self::STATUS_APPROVED,
    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'meta'         => 'array',
        'amount'       => 'decimal:2',
        'reference_id' => 'integer',
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
    | TYPES
    |--------------------------------------------------------------------------
    */

    public const TYPE_CAMPAIGN_CHARGE = 'campaign_charge';

    public const TYPE_EARNING = 'earning';

    public const TYPE_PLATFORM_FEE = 'platform_fee';

    public const TYPE_TOPUP = 'topup';

    public const TYPE_WITHDRAWAL = 'withdrawal';



    /*
    |--------------------------------------------------------------------------
    | CATEGORIES
    |--------------------------------------------------------------------------
    */

    public const CATEGORY_CLICK = 'click';

    public const CATEGORY_CAMPAIGN = 'campaign';

    public const CATEGORY_WITHDRAWAL = 'withdrawal';

    public const CATEGORY_ADJUSTMENT = 'adjustment';

    public const CATEGORY_GENERAL = 'general';



    /*
    |--------------------------------------------------------------------------
    | DIRECTIONS
    |--------------------------------------------------------------------------
    */

    public const DIRECTION_DEBIT = 'debit';

    public const DIRECTION_CREDIT = 'credit';



    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_CANCELLED = 'cancelled';



    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeApproved($query)
    {
        return $query->where(
            'status',
            self::STATUS_APPROVED
        );
    }



    public function scopeCredit($query)
    {
        return $query->where(
            'direction',
            self::DIRECTION_CREDIT
        );
    }



    public function scopeDebit($query)
    {
        return $query->where(
            'direction',
            self::DIRECTION_DEBIT
        );
    }



    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isCredit(): bool
    {
        return $this->direction === self::DIRECTION_CREDIT;
    }



    public function isDebit(): bool
    {
        return $this->direction === self::DIRECTION_DEBIT;
    }



    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }



    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }
}