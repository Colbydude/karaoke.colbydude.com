<?php

namespace Tests\Unit;

use App\Services\YouTubeService;
use PHPUnit\Framework\TestCase;

class YouTubeServiceTest extends TestCase
{
    /** @test */
    public function it_can_extract_video_id_from_valid_youtube_links()
    {
        $result = YouTubeService::extractIdFromUrl('https://www.youtube.com/watch?v=mbyzgeee2mg');
        $this->assertEquals($result, 'mbyzgeee2mg');

        $result = YouTubeService::extractIdFromUrl('https://youtube.com/watch?v=mbyzgeee2mg');
        $this->assertEquals($result, 'mbyzgeee2mg');

        $result = YouTubeService::extractIdFromUrl('https://youtube.com/mbyzgeee2mg');
        $this->assertEquals($result, 'mbyzgeee2mg');

        $result = YouTubeService::extractIdFromUrl('https://youtu.be/watch?v=mbyzgeee2mg');
        $this->assertEquals($result, 'mbyzgeee2mg');

        $result = YouTubeService::extractIdFromUrl('https://youtu.be/mbyzgeee2mg');
        $this->assertEquals($result, 'mbyzgeee2mg');
    }

    /** @test */
    public function it_returns_null_for_attempting_to_extract_video_id_from_invalid_links()
    {
        $result = YouTubeService::extractIdFromUrl('https://www.youtube.com');
        $this->assertNull($result);

        $result = YouTubeService::extractIdFromUrl('https://colbydude.com');
        $this->assertNull($result);
    }
}
