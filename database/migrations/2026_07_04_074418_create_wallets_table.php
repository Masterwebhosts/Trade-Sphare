<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();

            $table->morphs('owner');
            // owner_id
            // owner_type

            $table->string('currency', 10)->default('USD');
            $table->string('status', 30)->default('active');

            $table->timestamps();

            $table->unique(['owner_id', 'owner_type']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};