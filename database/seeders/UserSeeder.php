<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::create([
      'name' => 'Jose Maria',
      'email' => 'jmb@jmb.com',
      'password' => bcrypt('12345678'),
    ])->assignRole(['Admin', 'Autor']);

    User::factory(99)->create();
    $users = User::all();
    Config::set('tipo_imagen','FACE');
    foreach ($users as $user) {
      Image::factory(1)->create([
        'imageable_id' => $user->id,
        'imageable_type' => User::class
      ]);
      $user->update(['profile_photo_path' => $user->image->url]);
      if ($user->id > 1 && $user->id <= 10) {
        $user->assignRole(['Autor']);
      } elseif ($user->id > 10 && $user->id <= 88) {
        $user->assignRole(['Lector']);
      } elseif ($user->id >= 89 && $user->id <= 98) {
        $user->assignRole(['Editor']);
      } elseif ($user->id >= 99) {
        $user->assignRole(['Publicador']);
      }
    }
  }
}
