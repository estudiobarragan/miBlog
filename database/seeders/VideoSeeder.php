<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $videos = Video::factory(25)->create();
    foreach ($videos as $video) {
      Image::factory(1)->create([
        'imageable_id' => $video->id,
        'imageable_type' => Video::class
      ]);
    }
  }
}
