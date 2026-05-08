<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    public function sendMessage(string $chatId, string $text): bool
    {
        $botToken = config('services.telegram.bot_token');

        $response = Http::post(
            "https://api.telegram.org/bot{$botToken}/sendMessage",
            [
                'chat_id' => $chatId,
                'text' => $text,
                'disable_web_page_preview' => false,
            ]
        );

        return $response->successful();
    }
}
