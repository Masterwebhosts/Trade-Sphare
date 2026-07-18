<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_zone_ads', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | ZONE
            |--------------------------------------------------------------------------
            */

            $table->foreignId('ad_zone_id')
                ->constrained('ad_zones')
                ->cascadeOnDelete();



            /*
            |--------------------------------------------------------------------------
            | AD
            |--------------------------------------------------------------------------
            */

            $table->foreignId('ad_id')
                ->constrained('ads')
                ->cascadeOnDelete();



            $table->timestamps();



            /*
            |--------------------------------------------------------------------------
            | منع التكرار
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'ad_zone_id',
                'ad_id'
            ]);

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('ad_zone_ads');
    }
};