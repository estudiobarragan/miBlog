<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use App\Models\Video;
use Mmo\Faker\LoremSpaceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;
/* use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider; */


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
    $faker->addProvider(new LoremSpaceProvider($faker));

    if(Config::get('tipo_imagen')=='FACE'){
      $tipo = $faker->loremSpace(LoremSpaceProvider::CATEGORY_FACE, $dir = public_path('storage/img'), $width = 640, $height = 480, $fullPath = false);
    }else{
      $tipo = $faker->loremSpace(LoremSpaceProvider::CATEGORY_FURNITURE, $dir = public_path('storage/img'), $width = 640, $height = 480, $fullPath = false);
    }

    /* $faker->addProvider(new FakerPicsumImagesProvider($faker)); */
    return [
      'url' => 'img/' .$tipo,
      /* 'url' => 'img/' . $faker->image($dir = 'public/storage/img', $width = 640, $height = 480,  $fullPath = false), */
    ];
  }
}
