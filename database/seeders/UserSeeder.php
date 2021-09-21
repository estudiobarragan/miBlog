<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;
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

    foreach ($users as $user) {
      Image::factory(1)->create([
        'imageable_id' => $user->id,
        'imageable_type' => User::class
      ]);
      if ($user->id > 1 && $user->id <= 10) {
        $user->assignRole(['Autor']);
      } elseif ($user->id > 10 && $user->id <= 79) {
        $user->assignRole(['Lector']);
      } elseif ($user->id >= 80 && $user->id <= 89) {
        $user->assignRole(['Editor']);
      } elseif ($user->id >= 90) {
        $user->assignRole(['Publicador']);
      }
    }
  }
}
