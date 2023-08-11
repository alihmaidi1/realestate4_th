<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatecorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $categories = [
      "منزل",
      "محل",
      "شركة",
      "ارض",
    ];
    foreach ($categories as $category) {
      Category::create([
        "name" => $category,
      ]);
    }
  }
}
