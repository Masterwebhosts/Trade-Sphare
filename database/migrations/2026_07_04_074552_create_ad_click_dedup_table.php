<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_click_dedup', function (Blueprint $table) {

            $table->id();


            $table->foreignId('ad_id')
                ->constrained('ads')
                ->cascadeOnDelete();



            $table->foreignId('zone_id')
                ->constrained('ad_zones')
                ->cascadeOnDelete();



            /**
             * Visitor fingerprint
             * SHA1(ip + user_agent)
             */
            $table->string('fingerprint', 64);



            $table->timestamp('last_click_at')
                ->useCurrent()
                ->useCurrentOnUpdate();



            $table->timestamps();



            /**
             * Prevent duplicate clicks
             */
            $table->unique([
                'ad_id',
                'zone_id',
                'fingerprint',
            ]);

        });
    }



    public function down(): void
    {
        Schema::dropIfExists('ad_click_dedup');
    }
};