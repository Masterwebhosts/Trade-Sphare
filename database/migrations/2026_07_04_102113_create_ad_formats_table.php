<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_formats', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code');
            $table->string('size')->nullable();

            $table->text('description')->nullable();

            $table->string('status');

            $table->boolean('supports_video')->default(false);
            $table->boolean('supports_image')->default(true);
            $table->integer('max_assets')->default(1);

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_formats');
    }
};