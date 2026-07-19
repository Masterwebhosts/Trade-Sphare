<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clicks', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Campaign
            |--------------------------------------------------------------------------
            */

            $table->foreignId('campaign_id')
                ->constrained('campaigns')
                ->cascadeOnDelete();



            /*
            |--------------------------------------------------------------------------
            | Advertisement
            |--------------------------------------------------------------------------
            */

            $table->foreignId('ad_id')
                ->constrained('ads')
                ->cascadeOnDelete();



            /*
            |--------------------------------------------------------------------------
            | Publisher / Zone
            |--------------------------------------------------------------------------
            */

            $table->foreignId('publisher_id')
                ->constrained('users')
                ->cascadeOnDelete();



            $table->foreignId('zone_id')
                ->constrained('ad_zones')
                ->cascadeOnDelete();



            /*
            |--------------------------------------------------------------------------
            | Impression relation
            |--------------------------------------------------------------------------
            */

            $table->foreignId('impression_id')
                ->nullable()
                ->constrained('impressions')
                ->nullOnDelete();



            /*
            |--------------------------------------------------------------------------
            | Visitor Data
            |--------------------------------------------------------------------------
            */

            $table->string('ip_address', 255)
                ->nullable();


            $table->text('user_agent')
                ->nullable();


            $table->string('fingerprint', 64)
                ->nullable();



            /*
            |--------------------------------------------------------------------------
            | Fraud
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_fraud')
                ->default(false);



            $table->timestamps();



            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'campaign_id',
                'created_at'
            ]);


            $table->index([
                'ad_id',
                'created_at'
            ]);


            $table->index([
                'publisher_id',
                'created_at'
            ]);


            $table->index('zone_id');


            $table->index('is_fraud');


            $table->index('ip_address');


            $table->index('fingerprint');

        });
    }



    public function down(): void
    {
        Schema::dropIfExists('clicks');
    }
};