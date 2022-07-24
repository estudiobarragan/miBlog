<?php

namespace Database\Seeders;

use App\Models\Approve;
use App\Models\Image;
use App\Models\Post;
use App\Models\Publication;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;


class PostSeeder extends Seeder
{
  use HasFactory;
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = Factory::create();

    $posts = Post::factory(300)->create();
    $post4 = 0;
    $post5 = 0;

    foreach ($posts as $post) {
      Image::factory(1)->create([
        'imageable_id' => $post->id,
        'imageable_type' => Post::class
      ]);
      $post->tags()->attach([
        rand(1, 4),
        rand(5, 8)
      ]);
      if ($post->state_id >= 3) {
        Approve::create([
          'level'         => $faker->randomElement([1, 2, 3]),
          'timeToRead'    => $faker->randomElement([2, 5, 10, 15]),
          'linksSource'   => false,
          'understandable' => false,
          'title'         => false,
          'image'         => false,
          'summary'       => false,
          'conclusion'    => false,
          'examples'      => false,
          'tagRight'      => false,
          'categoryRight' => false,
          'feedback'      => $faker->text(),
          'approved'      => 1,
          'post_id'       => $post->id,
          'created_at'    => $post->created_at,
        ]);
      }
      if ($post->state_id == 4) {
        $post4 = $post4 + 1;
        $fechaPub = Carbon::now()->subDays($post4);
        $post->update(['publicar' => $fechaPub]);
      }
      if ($post->state_id >= 5) {
        $post5 = $post5 + 1;
        $fechaPub = Carbon::now()->subDays($post5);
        $post->update(['publicar' => $fechaPub]);
      }
    }
  }
}
