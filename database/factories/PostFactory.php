<?php

namespace Database\Factories;

use App\Models\Approve;
use App\Models\Categoria;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Post::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $editor = null;
    $publicador = null;
    $name = $this->faker->unique()->sentence();
    $state = $this->faker->randomElement([1, 2, 3, 4, 5]);
    if ($state >= 3) {
      $editor =  $this->faker->randomElement([80, 81, 82, 83, 84, 85, 86, 87, 88, 89]);
    }
    if ($state >= 4) {
      $publicador =  $this->faker->randomElement([90, 91, 92, 93, 94, 95, 96, 97, 98, 99]);
    }

    return [
      'name' => $name,
      'slug' => Str::slug($name),
      'extract' => $this->faker->text(250),
      'body' => $this->faker->text(2000),
      'categoria_id' => Categoria::all()->random()->id,
      'state_id' => $state,
      'user_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
      'editor_id' => $editor,
      'publicador_id' => $publicador,
    ];
  }
}
