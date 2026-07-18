<?php

namespace App\Services;

use App\Models\Withdrawal;
use App\Models\Wallet;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Services\Ledger\LedgerService;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class WithdrawalService
{
    public function __construct(
        protected LedgerService $ledger
    ) {
    }



    /*
    |--------------------------------------------------------------------------
    | CREATE REQUEST
    |--------------------------------------------------------------------------
    */

    public function request(
        int $publisherId,
        float $amount,
        string $iban,
        string $bankName
    ): Withdrawal {

        return DB::transaction(function () use (
            $publisherId,
            $amount,
            $iban,
            $bankName
        ) {


            if ($amount <= 0) {

                throw new RuntimeException(
                    'Invalid withdrawal amount'
                );

            }



            $wallet = Wallet::query()

                ->where(
                    'owner_type',
                    User::class
                )

                ->where(
                    'owner_id',
                    $publisherId
                )

                ->lockForUpdate()

                ->firstOrFail();



            if ($wallet->calculateBalance() < $amount) {

                throw new RuntimeException(
                    'Insufficient balance'
                );

            }



            return Withdrawal::create([

                'publisher_id' => $publisherId,

                'wallet_id' => $wallet->id,

                'amount' => $amount,

                'status' => 'pending',

                'iban' => $iban,

                'bank_name' => $bankName,

            ]);

        });

    }





    /*
    |--------------------------------------------------------------------------
    | ADMIN APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve(
        Withdrawal $withdrawal,
        int $adminId
    ): void {

        if (! $withdrawal->isPending()) {

            throw new RuntimeException(
                'Invalid withdrawal state'
            );

        }



        $withdrawal->update([

            'status' => 'approved',

            'admin_id' => $adminId,

        ]);

    }





    /*
    |--------------------------------------------------------------------------
    | ADMIN REJECT
    |--------------------------------------------------------------------------
    */

    public function reject(
        Withdrawal $withdrawal,
        int $adminId
    ): void {


        if ($withdrawal->isPaid()) {

            throw new RuntimeException(
                'Paid withdrawal cannot be rejected'
            );

        }



        $withdrawal->update([

            'status' => 'rejected',

            'admin_id' => $adminId,

        ]);

    }





    /*
    |--------------------------------------------------------------------------
    | PAYOUT
    |--------------------------------------------------------------------------
    */

    public function markPaid(
        Withdrawal $withdrawal
    ): void {


        DB::transaction(function () use ($withdrawal) {


            if (! $withdrawal->isApproved()) {

                throw new RuntimeException(
                    'Withdrawal must be approved first'
                );

            }



            $exists = WalletTransaction::query()

                ->where(
                    'reference_type',
                    'withdrawal'
                )

                ->where(
                    'reference_id',
                    $withdrawal->id
                )

                ->exists();



            if ($exists) {

                throw new RuntimeException(
                    'Withdrawal already processed'
                );

            }





            $this->ledger->record([

                [

                    'wallet_id' => $withdrawal->wallet_id,


                    'type' =>
                        WalletTransaction::TYPE_WITHDRAWAL,


                    'category' =>
                        WalletTransaction::CATEGORY_WITHDRAWAL,


                    'amount' =>
                        $withdrawal->amount,


                    'direction' =>
                        WalletTransaction::DIRECTION_DEBIT,


                    'status' =>
                        WalletTransaction::STATUS_APPROVED,


                    'reference_type' =>
                        'withdrawal',


                    'reference_id' =>
                        $withdrawal->id,


                ]

            ]);





            $withdrawal->update([

                'status' => 'paid',

                'processed_at' => now(),

            ]);

        });

    }
}