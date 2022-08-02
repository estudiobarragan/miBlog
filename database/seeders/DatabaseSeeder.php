<?php

namespace Database\Seeders;

use App\Models\Approve;
use App\Models\Categoria;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Video;
use Database\Seeders\FollowSeeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\ProfileSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StateSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\VideoSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    Storage::deleteDirectory('img');
    Storage::makeDirectory('img');

    $this->call(RoleSeeder::class);
    $this->call(UserSeeder::class);
    $this->call(ProfileSeeder::class);
    Categoria::factory(5)->create();
    $this->call(StateSeeder::class);
    Tag::factory(8)->create();
    $this->call(FollowSeeder::class);
    $this->call(PostSeeder::class);
    $this->call(VideoSeeder::class);
  }
}
