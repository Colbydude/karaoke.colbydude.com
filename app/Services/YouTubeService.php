<?php

namespace App\Services;

use Zttp\Zttp;

class YouTubeService
{
    /**
     * Extracts the video ID from a valid YouTube URL.
     *
     * @param  string  $url
     * @return string
     */
    public static function extractIdFromUrl($url)
    {
        $regex = "/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";
        $match;

        if (preg_match($regex, $url, $match)) {
            return $match[4];
        }

        return null;
    }

    /**
     * Gets information on the YouTube API about the video based on the ID.
     *
     * @param  string  $id
     * @return Object
     */
    public static function getDataById($id)
    {
        $response = Zttp::get('https://www.googleapis.com/youtube/v3/videos', [
            'id' => $id,
            'key' => config('services.youtube.key'),
            'part' => 'snippet',
        ]);

        return $response->json();
    }
}
