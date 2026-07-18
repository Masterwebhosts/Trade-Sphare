<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_targetings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ad_id')
                ->constrained('ads')
                ->cascadeOnDelete();

            $table->string('geo_country')->nullable();
            $table->string('geo_city')->nullable();

            $table->string('device', 20)->nullable();
            // mobile | desktop | tablet

            $table->string('os')->nullable();
            $table->string('browser')->nullable();

            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();

            $table->string('gender', 10)->nullable();
            // male | female | all

            $table->timestamps();

            $table->index('ad_id');
            $table->index('geo_country');
            $table->index('device');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_targetings');
    }
};