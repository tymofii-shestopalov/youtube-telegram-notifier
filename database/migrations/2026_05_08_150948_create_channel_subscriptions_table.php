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
        Schema::create('channel_subscriptions', function (Blueprint $table) 
        {
            $table->id();

            $table->foreignId('youtube_channel_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('telegram_channel_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->boolean('is_active')->default(true);

            $table->unique(
                ['youtube_channel_id', 'telegram_channel_id'],
                'channel_sub_unique'
            );

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_subscriptions');
    }
};
