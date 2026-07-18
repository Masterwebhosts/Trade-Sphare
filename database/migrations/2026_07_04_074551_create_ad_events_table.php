<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ad_id')
                ->constrained('ads')
                ->cascadeOnDelete();

            $table->foreignId('publisher_id')
               ->constrained('users')
               ->cascadeOnDelete();

            $table->foreignId('zone_id')
                ->nullable()
                ->constrained('ad_zones')
                ->nullOnDelete();

            $table->string('event_type', 20);
            // impression | click

            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index('ad_id');
            $table->index('event_type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_events');
    }
};