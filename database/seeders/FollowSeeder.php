<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Tag;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maize\Markable\Models\Favorite;

class FollowSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = Factory::create();

    $autores = User::role('Autor')->get();
    $etiquetas = Tag::all();
    $categorias = Categoria::all();

    foreach ($autores as $autor) {
      for ($i = 1; $i <= 10; $i++) {
        $follower = User::where('id', $faker->numberBetween(11, 88))->first();
        Favorite::add($autor, $follower);
      }
    }
    foreach ($etiquetas as $etiqueta) {
      for ($i = 1; $i <= 10; $i++) {
        $follower = User::where('id', $faker->numberBetween(11, 88))->first();
        Favorite::add($etiqueta, $follower);
      }
    }

    foreach ($categorias as $categoria) {
      for ($i = 1; $i <= 10; $i++) {
        $follower = User::where('id', $faker->numberBetween(11, 88))->first();
        Favorite::add($categoria, $follower);
      }
    }
  }
}
