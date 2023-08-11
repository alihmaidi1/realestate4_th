<?php

namespace Database\Seeders;

use App\Models\Location\Area;
use App\Models\Location\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $city_id = City::where('name', 'حلب')->first()->id;
    $areas = [
      "الفرقان",
      "الجميلية",
      "شارع النيل",
      "الشهباء",
      "الجامعة",
      "الاعظمية",
      "حلب الجديدة",
      "الزهراء",
      "الحمدانية",
      "بستان القصر",
      "الاذاعة",
      "الخالدية",
      "الاشرفية",
      "سيف الدولة",
    ];
    foreach ($areas as $area) {
      Area::create([
        "name" => $area,
        "city_id" => $city_id,
      ]);
    }
  }
}
