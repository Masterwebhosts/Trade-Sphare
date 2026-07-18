<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {

            $table->id();

            $table->foreignId('campaign_id')
                ->constrained('campaigns')
                ->cascadeOnDelete();


            // عنوان الإعلان
            $table->string('title');


            // وصف / نص الإعلان
            $table->text('description')
                ->nullable();


            // banner | video | text
            $table->string('content_type', 30);


            // رابط الصورة أو الفيديو
            $table->string('media_url')
                ->nullable();


            // رابط الانتقال
            $table->string('target_url');


            // draft | pending_review | approved | rejected | active | paused | archived
            $table->string('status', 30)
                ->default('pending_review');


            $table->timestamps();


            $table->index([
                'campaign_id',
                'status'
            ]);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};