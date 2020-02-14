<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SongRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requests')->insert([
            ['name' => 'Clob', 'video_name' => 'Incubus - Drive', 'youtube_link' => 'https://www.youtube.com/watch?v=fgT9zGkiLig', 'created_at' => Carbon::now()],
            ['name' => 'Owen', 'video_name' => 'My Chemical Romance - Welcome to the Black Parade', 'youtube_link' => 'https://www.youtube.com/watch?v=RRKJiM9Njr8', 'created_at' => Carbon::now()],
            ['name' => 'Evan', 'video_name' => 'The Killers - Mr. Brightside', 'youtube_link' => 'https://www.youtube.com/watch?v=gGdGFtwCNBE', 'created_at' => Carbon::now()],
            ['name' => 'Bryant', 'video_name' => 'Four Year Strong - It Must Really Suck To Be Four Year Strong Right Now', 'youtube_link' => 'https://www.youtube.com/watch?v=xtXa1lCVzUM', 'created_at' => Carbon::now()],
            ['name' => 'Simon', 'video_name' => 'RichaadEB & Friends - JoJo Golden Wind', 'youtube_link' => 'https://www.youtube.com/watch?v=fbiD4i_4kU0', 'created_at' => Carbon::now()],
            ['name' => 'tlo', 'video_name' => 'Porter Robinson - Shelter', 'youtube_link' => 'https://www.youtube.com/watch?v=fzQ6gRAEoy0', 'created_at' => Carbon::now()],
            ['name' => 'Ben', 'video_name' => 'A-ha - Take On Me', 'youtube_link' => 'https://www.youtube.com/watch?v=djV11Xbc914', 'created_at' => Carbon::now()],
            ['name' => 'Tofu', 'video_name' => 'Ghost - Dance Macabre', 'youtube_link' => 'https://www.youtube.com/watch?v=7Gr63DiEUxw', 'created_at' => Carbon::now()],
        ]);
    }
}
