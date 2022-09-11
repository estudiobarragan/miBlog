<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;

class ImageFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Image::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $faker = \Faker\Factory::create();
    $faker->addProvider(new FakerPicsumImagesProvider($faker));
    /* Log::info($this->faker->image($dir = 'public/storage/img', $width = 640, $height = 480,  $fullPath = false)); */
    return [
      'url' => 'img/' . $faker->image($dir = 'public/storage/img', $width = 640, $height = 480,  $fullPath = false),
    ];
  }
}
