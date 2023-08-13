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
      "منزل",
      "ارض",
      "محل",
    ];
    $informations = [
      [
        ['عدد الاسرة'],
        ['عدد الحمامات'],
        ['يوجد حديقة'],
        ['يوجد واي فاي'],
      ],
      [
        ['المساحة'],
        ['طابو اخضر'],
      ],
      [
        ['عدد الحمامات'],
        ['عدد الواجهات'],
        ['المساحة'],
        ['طابو اخضر'],
        ['الاتجاه'],
      ]
    ];
    foreach ($categories as $key => $category) {
      $created_category = Category::create(['name' => $category]);
      foreach ($informations[$key] as $info) {
        // dd($info[1]);
        Information::create([
          'name' => $info[0],
          'category_id' => $created_category->id,
          'code' => "facke code",
        ]);
      }
    }
  }
}
