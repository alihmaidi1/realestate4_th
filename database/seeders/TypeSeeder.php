<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('types')->delete();

    $types = ['بيع', 'اجار', 'رهن'];

    foreach ($types as $type) {
      Type::create([
        "name" => $type
      ]);
    }
  }
}
