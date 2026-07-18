<?php

namespace App\Services\Ledger;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class LedgerService
{
    /*
    |----------------------------------
    | CORE WRITER
    | SINGLE SOURCE OF TRUTH
    |----------------------------------
    */

    public function record(array $entries): void
    {
        if (empty($entries)) {
            throw new RuntimeException(
                'Ledger entries cannot be empty'
            );
        }


        DB::transaction(function () use ($entries) {

            foreach ($entries as $entry) {


                foreach (
                    [
                        'wallet_id',
                        'type',
                        'amount',
                        'direction'
                    ]
                    as $field
                ) {

                    if (! array_key_exists($field, $entry)) {

                        throw new RuntimeException(
                            "Missing required field: {$field}"
                        );
                    }
                }



                if (
                    ! in_array(
                        $entry['direction'],
                        [
                            WalletTransaction::DIRECTION_CREDIT,
                            WalletTransaction::DIRECTION_DEBIT,
                        ],
                        true
                    )
                ) {

                    throw new RuntimeException(
                        'Invalid transaction direction'
                    );
                }



                WalletTransaction::create([

                    'wallet_id'      => $entry['wallet_id'],

                    'type'           => $entry['type'],

                    'category'       =>
                        $entry['category'] ?? 'general',


                    /*
                     * Ledger keeps positive amounts
                     */
                    'amount'         =>
                        round(abs($entry['amount']), 2),


                    'direction'      =>
                        $entry['direction'],


                    'status'         =>
                        $entry['status']
                        ??
                        WalletTransaction::STATUS_APPROVED,


                    'reference_type' =>
                        $entry['reference_type'] ?? null,


                    'reference_id' =>
                        $entry['reference_id'] ?? null,


                    'meta' =>
                        $entry['meta'] ?? [],

                ]);

            }

        });
    }



    /*
    |----------------------------------
    | CLICK SPLIT ENGINE
    |----------------------------------
    */

    public function chargeClickWithSplit(
        int $campaignId,
        int $advertiserId,
        int $publisherId,
        float $amount,
        int $clickId,
        float $platformRate = 0.30
    ): void {


        if ($amount <= 0) {

            return;

        }



        DB::transaction(function () use (
            $campaignId,
            $advertiserId,
            $publisherId,
            $amount,
            $clickId,
            $platformRate
        ) {


            if (
                $this->hasLedgerEntry(
                    'click',
                    $clickId
                )
            ) {

                return;

            }



            $advertiserWallet =
                $this->getWallet($advertiserId);


            $publisherWallet =
                $this->getWallet($publisherId);


            $platformWallet =
                $this->getPlatformWallet();



            if (! $advertiserWallet) {

                throw new RuntimeException(
                    "Advertiser wallet missing: {$advertiserId}"
                );

            }


            if (! $publisherWallet) {

                throw new RuntimeException(
                    "Publisher wallet missing: {$publisherId}"
                );

            }


            if (! $platformWallet) {

                throw new RuntimeException(
                    'Platform wallet missing'
                );

            }



            $balance =
                $this->walletBalance(
                    $advertiserWallet->id
                );



            if ($balance < $amount) {

                throw new RuntimeException(
                    "Advertiser insufficient balance"
                );

            }



            $platformCut =
                round(
                    $amount * $platformRate,
                    2
                );


            $publisherCut =
                round(
                    $amount - $platformCut,
                    2
                );



            if ($publisherCut <= 0) {

                throw new RuntimeException(
                    'Invalid publisher earning amount'
                );

            }



            $this->record([


                [
                    'wallet_id' =>
                        $advertiserWallet->id,

                    'type' =>
                        WalletTransaction::TYPE_CAMPAIGN_CHARGE,

                    'category' =>
                        'click',

                    'amount' =>
                        $amount,

                    'direction' =>
                        WalletTransaction::DIRECTION_DEBIT,

                    'reference_type' =>
                        'click',

                    'reference_id' =>
                        $clickId,

                    'meta' =>
                        [
                            'campaign_id' =>
                                $campaignId,
                        ],
                ],



                [
                    'wallet_id' =>
                        $publisherWallet->id,

                    'type' =>
                        WalletTransaction::TYPE_EARNING,

                    'category' =>
                        'click',

                    'amount' =>
                        $publisherCut,

                    'direction' =>
                        WalletTransaction::DIRECTION_CREDIT,

                    'reference_type' =>
                        'click',

                    'reference_id' =>
                        $clickId,

                    'meta' =>
                        [
                            'campaign_id' =>
                                $campaignId,
                        ],
                ],



                [
                    'wallet_id' =>
                        $platformWallet->id,

                    'type' =>
                        WalletTransaction::TYPE_PLATFORM_FEE,

                    'category' =>
                        'click',

                    'amount' =>
                        $platformCut,

                    'direction' =>
                        WalletTransaction::DIRECTION_CREDIT,

                    'reference_type' =>
                        'click',

                    'reference_id' =>
                        $clickId,

                    'meta' =>
                        [
                            'campaign_id' =>
                                $campaignId,
                        ],
                ],

            ]);

        });

    }



    /*
    |----------------------------------
    | HELPERS
    |----------------------------------
    */


    private function hasLedgerEntry(
        string $referenceType,
        int $referenceId
    ): bool {

        return WalletTransaction::query()

            ->where(
                'reference_type',
                $referenceType
            )

            ->where(
                'reference_id',
                $referenceId
            )

            ->exists();

    }



    private function walletBalance(
        int $walletId
    ): float {


        return (float)

            WalletTransaction::query()

                ->where(
                    'wallet_id',
                    $walletId
                )

                ->where(
                    'status',
                    WalletTransaction::STATUS_APPROVED
                )

                ->selectRaw("
                    COALESCE(
                        SUM(
                            CASE
                                WHEN direction = 'credit'
                                THEN amount

                                WHEN direction = 'debit'
                                THEN -amount

                                ELSE 0

                            END
                        ),
                        0
                    ) AS balance
                ")

                ->value('balance');

    }



    private function getWallet(
        int $ownerId
    ): ?Wallet {

        return Wallet::query()

            ->where(
                'owner_type',
                User::class
            )

            ->where(
                'owner_id',
                $ownerId
            )

            ->first();

    }



    private function getPlatformWallet(): ?Wallet
    {

        return Wallet::query()

            ->where(
                'owner_type',
                User::class
            )

            ->whereHas(
                'owner',
                function ($q) {

                    $q->where(
                        'role',
                        'admin'
                    );

                }
            )

            ->first();

    }
}