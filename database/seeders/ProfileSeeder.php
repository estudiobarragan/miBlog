<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = Factory::create();
    $users = User::all();
    foreach ($users as $user) {
      $gen = $faker->randomElement(['male', 'female']);
      $user->profile()->create([
        'title' => $faker->title($gen),
        'biografia' => $faker->text(200),
        'website' => 'https://' . $faker->domainName(),
        'user_id' => $user->id,
        'telegram' => 'https://' . $faker->domainName(),
        'facebook' => 'https://' . $faker->domainName(),
        'instagram' => 'https://' . $faker->domainName(),
        'twitter' => 'https://' . $faker->domainName(),
        'tiktok' => 'https://' . $faker->domainName(),
      ]);
    }
  }
}
