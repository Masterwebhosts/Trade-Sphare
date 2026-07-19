<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Wallet
            |--------------------------------------------------------------------------
            */
            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Transaction Type (STRICT LEDGER TYPES)
            |--------------------------------------------------------------------------
            | campaign_charge
            | earning
            | platform_fee
            | topup
            | withdrawal
            | refund
            */
            $table->string('type', 30);

            /*
            |--------------------------------------------------------------------------
            | Money Direction
            |--------------------------------------------------------------------------
            | credit => increases wallet
            | debit  => decreases wallet
            */
            $table->enum('direction', ['credit', 'debit']);

            /*
            |--------------------------------------------------------------------------
            | Category (business grouping)
            |--------------------------------------------------------------------------
            */
            $table->string('category', 50);

            /*
            |--------------------------------------------------------------------------
            | Amount
            |--------------------------------------------------------------------------
            | Supports fractional CPC
            | Example: 0.025000
            */
            $table->decimal('amount', 14, 6);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */
            $table->string('status', 20)->default('approved');

            /*
            |--------------------------------------------------------------------------
            | Reference (ledger linking)
            |--------------------------------------------------------------------------
            */
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */
            $table->json('meta')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */
            $table->index('wallet_id');
            $table->index('type');
            $table->index('direction');
            $table->index('category');
            $table->index('status');

            $table->index([
                'reference_type',
                'reference_id'
            ]);

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};