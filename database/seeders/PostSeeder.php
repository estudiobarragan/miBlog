<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Faker\Core\Number;
use App\Models\Approve;
use App\Models\Comment;
use App\Models\Categoria;
use App\Models\Publication;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Maize\Markable\Models\Like;
use Maize\Markable\Models\Bookmark;
use Maize\Markable\Models\Reaction;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    $usuarios = User::all()->pluck('id');

    Config::set('tipo_imagen','ALL');
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
        $fechaPub = Carbon::now()->addDays($post4);
        $post->update(['publicar' => $fechaPub]);
      }
      if ($post->state_id >= 5) {
        $fechaPub = $faker->dateTimeBetween($post->created_at, Carbon::now(), null);
        $post->update(['publicar' => $fechaPub]);
        for ($i = 1; $i <= 10; $i++) {
          $user = User::where('id', $faker->numberBetween(11, 88))->first();
          Bookmark::add($post, $user);
        }
        for ($i = 1; $i <= 10; $i++) {
          $like = $faker->boolean(80);
          $user = User::where('id', $faker->numberBetween(11, 88))->first();
          if ($like) {
            Like::add($post, $user);
            $react = $faker->randomElement(['thumbup', 'heart', 'star']);
          } else {
            $react = $faker->randomElement(['thumbdown', 'brokenheart', 'unhappy']);
          }
          Reaction::add($post, $user, $react);
        }
      }

      Comment::factory()->create([
        'commentable_id' => $post->id,
      ]);
      $coment = Comment::factory()->create([
        'commentable_id' => $post->id,
      ]);
      $coment2 = Comment::factory()->create([
        'commentable_id' => $coment->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
      Comment::factory()->create([
        'commentable_id' => $coment2->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
      Comment::factory()->create([
        'commentable_id' => $coment2->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
      Comment::factory()->create([
        'commentable_id' => $post->id,
      ]);
      $coment = Comment::factory()->create([
        'commentable_id' => $post->id,
      ]);
      $coment2 = Comment::factory()->create([
        'commentable_id' => $coment->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
      Comment::factory()->create([
        'commentable_id' => $coment2->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
      Comment::factory()->create([
        'commentable_id' => $coment2->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
    }
  }
}
