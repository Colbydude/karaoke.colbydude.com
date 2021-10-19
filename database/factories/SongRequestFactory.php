<?php

namespace Database\Factories;

use App\Models\SongRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class SongRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SongRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new \Faker\Provider\Youtube($this->faker));

        return [
            'name' => $this->faker->name(),
            'youtube_link' => $this->faker->youtubeRandomUri(),
            'video_name' => $this->faker->words(3, true)
        ];
    }
}
