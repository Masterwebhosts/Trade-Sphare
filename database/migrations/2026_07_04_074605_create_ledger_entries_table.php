<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->cascadeOnDelete();

            $table->string('direction', 10);
            // debit | credit

            $table->decimal('amount', 12, 2);

            $table->string('source_type', 30);
            // click | campaign | withdrawal | adjustment

            $table->unsignedBigInteger('source_id');

            $table->decimal('balance_after', 12, 2)->nullable();

            $table->timestamps();

            // indexes (critical for audit + performance)
            $table->index('wallet_id');
            $table->index(['source_type', 'source_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ledger_entries');
    }
};