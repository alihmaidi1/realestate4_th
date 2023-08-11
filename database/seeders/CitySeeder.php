<?php

namespace Database\Seeders;

use App\Models\Location\City;
use App\Models\Location\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $country_id = Country::where('name','سوريا')->first()->id;
    $cities = [
      "حلب",
      "دمشق",
      "ريف دمشق",
      "حمص",
      "حماة",
      "ادلب",
      "درعا",
      "القنيطرة",
      "السويداء",
      "اللاذقية",
      "طرطوس",
      "دير الزور",
      "الحسكة",
      "الرقة",
    ];
    foreach ($cities as $city) {
      City::create([
        "name" => $city,
        "country_id" => $country_id,
      ]);
    }
  }
}
