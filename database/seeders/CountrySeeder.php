<?php

namespace Database\Seeders;

use App\Models\Location\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $countries = [
      "سوريا",
      "الاردن",
      "فلسطين",
      "تركيا",
      "العراق",
    ];
    foreach ($countries as $country) {
      Country::create([
        "name" => $country,
      ]);
    }
  }
}
