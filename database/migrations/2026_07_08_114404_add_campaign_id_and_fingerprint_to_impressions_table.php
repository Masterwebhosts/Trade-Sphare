<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('impressions', function (Blueprint $table) {

            $table->foreignId('campaign_id')
    ->nullable()
    ->after('ad_id')
    ->constrained()
    ->cascadeOnDelete();

$table->string('fingerprint', 64)
    ->nullable()
    ->after('user_agent');
        });
    }

    public function down(): void
    {
        Schema::table('impressions', function (Blueprint $table) {

            $table->dropForeign([
                'campaign_id'
            ]);

            $table->dropColumn([
                'campaign_id',
                'fingerprint',
            ]);

        });
    }
};