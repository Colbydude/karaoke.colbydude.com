<?php

namespace Tests\Unit;

use App\Services\YouTubeApiService;
use PHPUnit\Framework\TestCase;

class YouTubeApiServiceTest extends TestCase
{
    private YouTubeApiService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new YouTubeApiService();
    }

    /** @test */
    public function it_can_extract_video_id_from_valid_youtube_links()
    {
        $result = $this->service->extractIdFromUrl('https://www.youtube.com/watch?v=mbyzgeee2mg');
        $this->assertEquals($result, 'mbyzgeee2mg');

        $result = $this->service->extractIdFromUrl('https://youtube.com/watch?v=mbyzgeee2mg');
        $this->assertEquals($result, 'mbyzgeee2mg');

        $result = $this->service->extractIdFromUrl('https://youtube.com/mbyzgeee2mg');
        $this->assertEquals($result, 'mbyzgeee2mg');

        $result = $this->service->extractIdFromUrl('https://youtu.be/watch?v=mbyzgeee2mg');
        $this->assertEquals($result, 'mbyzgeee2mg');

        $result = $this->service->extractIdFromUrl('https://youtu.be/mbyzgeee2mg');
        $this->assertEquals($result, 'mbyzgeee2mg');
    }

    /** @test */
    public function it_returns_null_for_attempting_to_extract_video_id_from_invalid_links()
    {
        $result = $this->service->extractIdFromUrl('https://www.youtube.com');
        $this->assertNull($result);

        $result = $this->service->extractIdFromUrl('https://colbydude.com');
        $this->assertNull($result);
    }
}
