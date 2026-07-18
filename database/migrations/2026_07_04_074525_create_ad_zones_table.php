<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_zones', function (Blueprint $table) {

            $table->id();

            $table->foreignId('publisher_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('zone_type', 30);
            // banner | video | native


            $table->foreignId('governorate_id')
                ->nullable()
                ->constrained('governorates')
                ->nullOnDelete();


            $table->string('token', 64)
                ->unique();

            $table->string('status', 30)
                ->default('active');
            // active | inactive

            $table->timestamps();


            $table->index('publisher_id');
            $table->index('status');
            $table->index('zone_type');
            $table->index('governorate_id');

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('ad_zones');
    }
};