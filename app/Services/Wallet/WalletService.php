<?php

namespace App\Services\Wallet;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class WalletService
{
    /**
     * Resolve wallet for any persisted owner model
     * (pure resolver - no business logic)
     */
    public static function resolve(Model $owner): Wallet
    {
        if (!$owner->exists) {
            throw new InvalidArgumentException('Wallet owner must be a persisted model');
        }

        return Wallet::firstOrCreate(
            [
                'owner_id'   => $owner->getKey(),
                'owner_type' => $owner->getMorphClass(),
            ],
            [
                'currency' => 'USD',
            ]
        );
    }
}