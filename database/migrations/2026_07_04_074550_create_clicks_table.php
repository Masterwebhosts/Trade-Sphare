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


            $table->foreignId('ad_id')
                ->constrained('ads')
                ->cascadeOnDelete();



            // Publisher is a User with role=publisher
            $table->foreignId('publisher_id')
                ->constrained('users')
                ->cascadeOnDelete();



            $table->foreignId('zone_id')
                ->constrained('ad_zones')
                ->cascadeOnDelete();



            $table->foreignId('impression_id')
                ->nullable()
                ->constrained('impressions')
                ->nullOnDelete();



            $table->string('ip_address', 255)
                ->nullable();



            $table->text('user_agent')
                ->nullable();



            /**
             * Visitor fingerprint
             * SHA1(ip + user_agent)
             */
            $table->string('fingerprint', 64)
                ->nullable();



            $table->boolean('is_fraud')
                ->default(false);



            $table->timestamps();



            $table->index([
                'ad_id',
                'created_at'
            ]);


            $table->index([
                'publisher_id',
                'created_at'
            ]);


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