<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VideoFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Video::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $url = [
      'https://www.youtube.com/watch?v=tQ3WMluvcR0',
      'https://www.youtube.com/watch?v=uINilnFCKQ8',
      'https://www.youtube.com/watch?v=eNHJjGkTLy4',
      'https://www.youtube.com/watch?v=TdCaOgm4wUM',
      'https://www.youtube.com/watch?v=2TRMRxx4HFQ',
    ];
    $name = $this->faker->unique()->sentence();
    return [
      'name' => $name,
      'slug' => Str::slug($name),
      'description' => $this->faker->text(250),
      'url' => $this->faker->randomElement($url),
      'categoria_id' => Categoria::all()->random()->id,
      'user_id' => User::all()->random()->id,
    ];
  }
}
