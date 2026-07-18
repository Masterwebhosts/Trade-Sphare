<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publisher_earning_batches', function (Blueprint $table) {
            $table->id();

            // Publisher stored in users table with role=publisher
            $table->foreignId('publisher_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('total_amount', 12, 2);

            $table->string('status', 30);
            // pending | processed | paid

            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index('publisher_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publisher_earning_batches');
    }
};