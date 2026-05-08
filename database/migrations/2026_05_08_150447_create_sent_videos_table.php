<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sent_videos', function (Blueprint $table) 
        {
            $table->id();

            $table->foreignId('youtube_channel_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('video_id')->unique();
            $table->string('title')->nullable();
            $table->string('url');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('sent_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_videos');
    }
};
