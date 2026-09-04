<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_integrations', function (Blueprint $table) {
            $table->id();

            // Integration identity
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Authentication
            $table->string('api_key', 80)->unique();
            $table->string('api_secret_hash');

            // Approval lifecycle
            $table->enum('status', [
                'pending',
                'approved',
                'suspended',
                'revoked',
            ])->default('pending');

            // API permissions
            $table->json('permissions')->nullable();

            // Security / limits
            $table->unsignedInteger('rate_limit')->default(60);
            $table->json('allowed_ips')->nullable();

            // Activity
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('revoked_at')->nullable();

            // Admin who created the integration
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('status');
            $table->index('last_used_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_integrations');
    }
};
