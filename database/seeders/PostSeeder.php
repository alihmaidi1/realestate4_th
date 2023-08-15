<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use App\Models\Post;
use App\Models\Type;
use App\Models\User;
use App\Models\Category;
use App\Models\Location\Area;
use Illuminate\Database\Seeder;


class PostSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $faker = Factory::create('ar_SA');

    for ($i = 0; $i < 100; $i++) {
      $category = Category::inRandomOrder()->first();
      $post = Post::create([
        'user_id' => User::inRandomOrder()->first()->id,
        'area_id' => Area::inRandomOrder()->first()->id,
        'category_id' => $category->id,
        'longitude' => mt_rand(99999, 999999999),
        'latitude' => mt_rand(99999, 999999999),
        'description' => $faker->text(),
        'available' => rand(0, 1),
        'image_main' => $faker->imageUrl(),

      ]);


      for ($j = 0; $j < rand(2, 5); $j++) {
        $path = $faker->imageUrl();
        // Create a new image record and associate it with the post
        $post->images()->create([
          'path' => $path,
        ]);
      }

      foreach ($category->informations as $info) {

        // InformationPost::create([
        //   'information_id' => $info->id,
        //   'post_id' => $post->id,
        //   'value' => "val from seeder " . $info->name,
        // ]);

        $post->informations()->attach([$info->id => [
          'value' => "val from seeder " . $info->name,
        ]]);
      }

      $post->types()->attach([Type::inRandomOrder()->first()->id => [
        'price'      => mt_rand(100, 1000),
        'start_date' => Carbon::now()->subDays(mt_rand(5, 50)),
        'end_date'   => now()->addDays(mt_rand(5, 50)),
      ]]);
    }
  }
}
