<?php

namespace App\Console\Commands;

use App\Models\SentVideo;
use App\Models\YoutubeChannel;
use App\Services\TelegramService;
use App\Services\YouTubeService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:check-youtube-videos')]
#[Description('Command description')]
class CheckYoutubeVideos extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(
        YouTubeService $youTubeService,
        TelegramService $telegramService
    )
    {
        $youtubeChannels = YoutubeChannel::all();

        foreach ($youtubeChannels as $youtubeChannel) {

            $videos = $youTubeService
                ->getLatestVideos($youtubeChannel->channel_id);

            foreach ($videos as $video) {

                $alreadySent = SentVideo::where([
                    'youtube_channel_id' => $youtubeChannel->id,
                    'video_id' => $video['video_id'],
                ])->exists();

                if ($alreadySent) {
                    continue;
                }

                foreach ($youtubeChannel->telegramChannels as $telegramChannel) {

                    $telegramService->sendMessage(
                        $telegramChannel->chat_id,
                        $video['title'] . "\n" . $video['url']
                    );
                }

                SentVideo::create([
                    'youtube_channel_id' => $youtubeChannel->id,
                    'video_id' => $video['video_id'],
                    'title' => $video['title'],
                    'url' => $video['url'],
                    'published_at' => $video['published_at'],
                    'sent_at' => now(),
                ]);
            }
        }
    }
}
