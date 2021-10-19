<?php

namespace Tests\Feature;

use App\Events\SongRequestCreated;
use App\Events\SongRequestDeleted;
use App\Events\SongRequestsCleared;
use App\Models\SongRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RequestControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();

        Event::fake();
    }

    /** @test */
    public function it_can_fetch_a_list_of_requests()
    {
        $requests = [
            ['name' => 'Colby', 'video_name' => 'Ylvis - Stonehenge [Official music video HD] [Explicit lyrics]', 'youtube_link' => 'https://www.youtube.com/watch?v=mbyzgeee2mg'],
            ['name' => 'Owen', 'video_name' => 'My Chemical Romance - Welcome To The Black Parade [Official Music Video]', 'youtube_link' => 'https://www.youtube.com/watch?v=RRKJiM9Njr8']
        ];

        foreach ($requests as $request) {
            SongRequest::factory()->create($request);

            $this->assertDatabaseHas('requests', $request);
        }

        $response = $this->json('GET', route('song-requests.index'));

        $response->assertStatus(200)
                 ->assertJson($requests);
    }

    /** @test */
    public function it_can_fetch_a_single_request()
    {
        $request = SongRequest::factory()->create();

        $this->assertDatabaseHas('requests', $request->toArray());

        $response = $this->json('GET', route('song-requests.show', $request->id));

        $response->assertStatus(200)
                 ->assertJson($request->toArray());
    }

    /** @test */
    public function it_should_404_for_a_non_existent_request_on_show()
    {
        $response = $this->json('GET', route('song-requests.show', 42));

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_store_a_request()
    {
        $data = ['name' => 'Clob', 'youtube_link' => 'https://www.youtube.com/watch?v=-nqRkAsZumc'];

        $response = $this->json('POST', route('song-requests.store'), $data);

        $data['video_name'] = 'Incubus - Stellar (Official Music Video)';

        $response->assertStatus(201)
                 ->assertJson($data);
        $this->assertDatabaseHas('requests', $data);

        Event::assertDispatched(SongRequestCreated::class, function ($e) use ($data) {
            return $e->song_request->name === $data['name'];
        });
    }

    /** @test */
    public function it_should_422_for_invalid_youtube_links_when_storing()
    {
        $data = ['name' => 'Clob', 'youtube_link' => 'https://youtube.com'];

        $response = $this->json('POST', route('song-requests.store'), $data);

        $response->assertStatus(422)
                 ->assertJson([
                     'errors' => [
                         'youtube_link' => ['This must be a valid YouTube link.']
                     ]
                 ]);
    }

    /** @test */
    public function it_can_update_a_request()
    {
        $request = SongRequest::factory()->create();

        $this->assertDatabaseHas('requests', $request->toArray());

        $data = ['name' => 'Ben', 'video_name' => 'Tangled - I See The Light (Karaoke Version)', 'youtube_link' => 'https://www.youtube.com/watch?v=FLgWioSXAQU'];

        $response = $this->json('PUT', route('song-requests.update', $request->id), $data);

        $response->assertStatus(200)
                 ->assertJson($data);

        $this->assertDatabaseHas('requests', $data);
    }

    /** @test */
    public function it_can_delete_a_request()
    {
        $request = SongRequest::factory()->create();
        $this->assertDatabaseHas('requests', $request->toArray());

        $response = $this->json('DELETE', route('song-requests.destroy', $request->id));
        $response->assertStatus(200);

        $this->assertDatabaseMissing('requests', $request->toArray());

        Event::assertDispatched(SongRequestDeleted::class, function ($e) use ($request) {
            return $e->song_request->name === $request->name;
        });
    }

    /** @test */
    public function it_can_clear_all_requests()
    {
        $request = SongRequest::factory()->create();
        $this->assertDatabaseHas('requests', $request->toArray());

        $response = $this->json('DELETE', route('song-requests.clear'));
        $response->assertStatus(200);

        $this->assertDatabaseMissing('requests', $request->toArray());

        Event::assertDispatched(SongRequestsCleared::class, 1);
    }
}
