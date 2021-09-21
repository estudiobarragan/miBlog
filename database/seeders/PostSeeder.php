<?php

namespace Database\Seeders;

use App\Models\Approve;
use App\Models\Image;
use App\Models\Post;
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
        ]);
      }
    }
  }
}
