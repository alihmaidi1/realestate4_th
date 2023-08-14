<?php

namespace Database\Seeders;

use App\Models\Catecory;
use App\Models\Category;
use App\Models\Information;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InformationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $categories = [
      [
        "name" => "apartment",
        "image_url" => null,
        "description" => "apartment"
      ],
      [
        "name" => "land",
        "image_url" => null,
        "description" => "land"
      ],
      [
        "name" => "villa",
        "image_url" => null,
        "description" => "villa"
      ],
      [
        "name" => "market",
        "image_url" => null,
        "description" => "market"
      ],
      [
        "name" => "farm",
        "image_url" => null,
        "description" => "farm"
      ]
    ];
    $informations = [
      [
        "name" => "price",
        "category_id" => 1,
        "code" => "0x11111"
      ],
      [

        "name" => "floor",
        "category_id" => 1,
        "code" => "0x11111"
      ],
      [

        "name" => "rooms",
        "category_id" => 1,
        "code" => "0x11111"
      ],
      [
        "name" => "direction",
        "category_id" => 1,
        "code" => "0x11111"
      ],
      [
        "name" => "price",
        "category_id" => 2,
        "code" => "0x11111"
      ],
      [
        "name" => "size",
        "category_id" => 2,
        "code" => "0x11111"
      ],
      [
        "name" => "specification",
        "category_id" => 2,
        "code" => "0x11111"
      ],
      [
        "name" => "price",
        "category_id" => 3,
        "code" => "0x11111"
      ],
      [
        "name" => "floor",
        "category_id" => 3,
        "code" => "0x11111"
      ],
      [
        "name" => "rooms",
        "category_id" => 3,
        "code" => "0x11111"
      ],
      [
        "name" => "swimmingPool",
        "category_id" => 3,
        "code" => "0x11111"
      ],
      [
        "name" => "garden",
        "category_id" => 3,
        "code" => "0x11111"
      ],
      [
        "name" => "price",
        "category_id" => 4,
        "code" => "0x11111"
      ],
      [
        "name" => "floor",
        "category_id" => 4,
        "code" => "0x11111"
      ],
      [
        "name" => "storeHouse",
        "category_id" => 4,
        "code" => "0x11111"
      ],
      [
        "name" => "size",
        "category_id" => 4,
        "code" => "0x11111"
      ],
      [
        "name" => "price",
        "category_id" => 5,
        "code" => "0x11111"
      ],
      [
        "name" => "playGround",
        "category_id" => 5,
        "code" => "0x11111"
      ],
      [
        "name" => "section",
        "category_id" => 5,
        "code" => "0x11111"
      ],
      [
        "name" => "rooms",
        "category_id" => 5,
        "code" => "0x11111"
      ],
      [
        "name" => "swimmingPool",
        "category_id" => 5,
        "code" => "0x11111"
      ]
    ];
    foreach ($categories as $key => $category) {
      Category::create([
        'name' => $category['name'],
        'image_url' => $category['image_url'],
        'description' => $category['description']
      ]);
    }
    foreach ($informations as $i => $info) {
      Information::create([
        'name' => $info['name'],
        'category_id' => $info['category_id'],
        'code' => $info['code'],
      ]);
    }
  }
}
