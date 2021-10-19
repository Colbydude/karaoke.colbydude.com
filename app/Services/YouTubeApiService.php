<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class YouTubeApiService
{
    /**
     * The API key used for requests.
     */
    private ?string $apiKey;

    /**
     * The Base URI of the YouTube API.
     */
    private string $baseUri = 'https://www.googleapis.com';

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Extracts the video ID from a valid YouTube URL.
     *
     * @param  string  $url
     * @return string
     */
    public function extractIdFromUrl($url)
    {
        $regex = "/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";
        $match = [];

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
    public function getDataById($id)
    {
        return $this->request('youtube/v3/videos', [
            'id' => $id,
            'key' => $this->apiKey,
            'part' => 'snippet'
        ]);
    }

    /**
     * Sends an HTTP request to the YouTube API.
     *
     * @param  string  $url
     * @param  mixed   $params
     * @param  string  $method
     * @return mixed
     */
    private function request(string $url, mixed $params = [], string $method = 'GET'): mixed
    {
        if ($this->apiKey == null) {
            throw new Exception('YouTube API Key not specified.');
        }

        $client = new Client(['base_uri' => $this->baseUri]);
        $response = $client->request($method, $url, [
            'query' => $params,
        ]);

        return json_decode((string) $response->getBody());
    }
}
