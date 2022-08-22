<?php

namespace Database\Seeders;

use App\Models\Approve;
use App\Models\Categoria;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\Publication;
use App\Models\User;
use Carbon\Carbon;
use Faker\Core\Number;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Maize\Markable\Models\Bookmark;
use Maize\Markable\Models\Like;
use Maize\Markable\Models\Reaction;

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

      $user = $faker->randomElement($usuarios);
      Comment::create([
        'user_id' => $user,
        'mensaje' => $faker->paragraph($faker->numberBetween(1, 5)),
        'commentable_id' => $post->id,
        'commentable_type' => 'App\Models\Post',
      ]);
      $user = $faker->randomElement($usuarios);
      $coment = Comment::create([
        'user_id' => $user,
        'mensaje' => $faker->paragraph($faker->numberBetween(1, 5)),
        'commentable_id' => $post->id,
        'commentable_type' => 'App\Models\Post',
      ]);
      $user = $faker->randomElement($usuarios);
      $coment2 = Comment::create([
        'user_id' => $user,
        'mensaje' => $faker->paragraph($faker->numberBetween(1, 5)),
        'commentable_id' => $coment->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
      $user = $faker->randomElement($usuarios);
      Comment::create([
        'user_id' => $user,
        'mensaje' => $faker->paragraph($faker->numberBetween(1, 5)),
        'commentable_id' => $coment2->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
      $user = $faker->randomElement($usuarios);
      Comment::create([
        'user_id' => $user,
        'mensaje' => $faker->paragraph($faker->numberBetween(1, 5)),
        'commentable_id' => $coment2->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
      $user = $faker->randomElement($usuarios);
      Comment::create([
        'user_id' => $user,
        'mensaje' => $faker->paragraph($faker->numberBetween(1, 5)),
        'commentable_id' => $post->id,
        'commentable_type' => 'App\Models\Post',
      ]);
      $user = $faker->randomElement($usuarios);
      $coment = Comment::create([
        'user_id' => $user,
        'mensaje' => $faker->paragraph($faker->numberBetween(1, 5)),
        'commentable_id' => $post->id,
        'commentable_type' => 'App\Models\Post',
      ]);
      $user = $faker->randomElement($usuarios);
      $coment2 = Comment::create([
        'user_id' => $user,
        'mensaje' => $faker->paragraph($faker->numberBetween(1, 5)),
        'commentable_id' => $coment->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
      $user = $faker->randomElement($usuarios);
      Comment::create([
        'user_id' => $user,
        'mensaje' => $faker->paragraph($faker->numberBetween(1, 5)),
        'commentable_id' => $coment2->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
      $user = $faker->randomElement($usuarios);
      Comment::create([
        'user_id' => $user,
        'mensaje' => $faker->paragraph($faker->numberBetween(1, 5)),
        'commentable_id' => $coment2->id,
        'commentable_type' => 'App\Models\Comment',
      ]);
    }
  }
}
