<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Location\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  protected $model = Post::class;

  public function definition()
  {
    return [
      'user_id' => User::inRandomOrder()->first()->id,
      'area_id' => Area::inRandomOrder()->first()->id,
      'category_id' => Category::inRandomOrder()->first()->id,
      'longitude' => $this->faker->longitude,
      'latitude' => $this->faker->latitude,
      'description' => $this->faker->text,
      'available' => rand(0, 1),
      'image_main' => $this->faker->imageUrl(),
    ];
  }
}
