<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impressions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ad_id')
                ->constrained('ads')
                ->cascadeOnDelete();

            // Publisher أصبح User
            $table->foreignId('publisher_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('zone_id')
                ->constrained('ad_zones')
                ->cascadeOnDelete();

            $table->string('ip_address')->nullable();

            $table->text('user_agent')->nullable();

            $table->string('country')->nullable();

            $table->string('city')->nullable();

            $table->string('device_type', 20)->nullable();

            $table->timestamps();

            $table->index('ad_id');
            $table->index('publisher_id');
            $table->index('zone_id');
            $table->index('ip_address');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impressions');
    }
};