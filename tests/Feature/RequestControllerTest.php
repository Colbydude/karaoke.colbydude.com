<?php

namespace Tests\Feature;

use App\Events\SongRequestCreated;
use App\SongRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RequestControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_fetch_a_list_of_requests()
    {
        $requests = [
            ['name' => 'Colby', 'video_name' => 'Ylvis - Stonehenge [Official music video HD] [Explicit lyrics]', 'youtube_link' => 'https://www.youtube.com/watch?v=mbyzgeee2mg'],
            ['name' => 'Owen', 'video_name' => 'My Chemical Romance - Welcome To The Black Parade [Official Music Video]', 'youtube_link' => 'https://www.youtube.com/watch?v=RRKJiM9Njr8']
        ];

        foreach ($requests as $request) {
            factory(SongRequest::class)->create($request);

            $this->assertDatabaseHas('requests', $request);
        }

        $response = $this->get(route('song-requests.index'));

        $response->assertStatus(200)
                 ->assertJson($requests);
    }

    /** @test */
    public function it_can_fetch_a_single_request()
    {
        $request = factory(SongRequest::class)->create();

        $this->assertDatabaseHas('requests', $request->toArray());

        $response = $this->get(route('song-requests.show', $request->id));

        $response->assertStatus(200)
                 ->assertJson($request->toArray());
    }

    /** @test */
    public function it_should_404_for_a_non_existent_request_on_show()
    {
        $response = $this->get(route('song-requests.show', 42));

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_store_a_request()
    {
        Event::fake();

        $data = ['name' => 'Clob', 'video_name' => 'Incubus - Stellar (Official Music Video)', 'youtube_link' => 'https://www.youtube.com/watch?v=-nqRkAsZumc'];

        $response = $this->post(route('song-requests.store'), $data);
        $response->assertStatus(201)
                 ->assertJson($data);
        $this->assertDatabaseHas('requests', $data);

        Event::assertDispatched(SongRequestCreated::class, function ($e) use ($data) {
            return $e->song_request->name === $data['name'];
        });
    }

    /** @test */
    public function it_can_update_a_request()
    {
        $request = factory(SongRequest::class)->create();

        $this->assertDatabaseHas('requests', $request->toArray());

        $data = ['name' => 'Ben', 'video_name' => 'Tangled - I See The Light (Karaoke Version)', 'youtube_link' => 'https://www.youtube.com/watch?v=FLgWioSXAQU'];

        $response = $this->put(route('song-requests.update', $request->id), $data);

        $response->assertStatus(200)
                 ->assertJson($data);

        $this->assertDatabaseHas('requests', $data);
    }

    /** @test */
    public function it_can_delete_a_request()
    {
        $request = factory(SongRequest::class)->create();

        $this->assertDatabaseHas('requests', $request->toArray());

        $response = $this->delete(route('song-requests.destroy', $request->id));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('requests', $request->toArray());
    }
}
