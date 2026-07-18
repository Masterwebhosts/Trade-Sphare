<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ad_id')
                ->constrained('ads')
                ->cascadeOnDelete();

            $table->foreignId('reviewed_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('status', 30);
            // approved | rejected

            $table->text('reason')->nullable();

            $table->timestamps();

            $table->index('ad_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_reviews');
    }
};