<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            $table->enum('type', [
                'plugin',
                'theme',
                'template',
                'service',
                'digital',
            ])->default('digital');

            $table->decimal('price', 12, 2)->default(0);
            $table->string('currency', 3)->default('USD');

            $table->boolean('is_subscription')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index('type');
            $table->index('is_subscription');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};