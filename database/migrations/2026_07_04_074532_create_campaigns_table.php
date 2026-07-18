<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();

            $table->foreignId('advertiser_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('governorate_id')
                ->nullable()
                ->constrained('governorates')
                ->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->string('status', 30);
            // draft, pending_approval, approved, rejected, active, paused, completed

            $table->decimal('budget_total', 12, 2);

            // cache only (NOT source of truth)
            $table->decimal('budget_spent', 12, 2)->default(0);

            // cache only (NOT source of truth)
            $table->decimal('budget_remaining', 12, 2)->default(0);

            $table->decimal('cpc', 10, 2)->default(0);

            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();

            $table->index('advertiser_id');
            $table->index('governorate_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};