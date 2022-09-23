<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::all()->random(1)->first();
        $post = Post::all()->random(1)->first();
        return [
            'user_id' => $user,
            'mensaje' => $this->faker->paragraph($this->faker->numberBetween(1, 5)),
            'commentable_id' => $post->id,
            'commentable_type' => 'App\Models\Post',
        ];
    }
}
