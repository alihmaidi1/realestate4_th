<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateAllPermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('permissions')->delete();

    $all_permissions = Config("global.permissions");
    foreach ($all_permissions as $key => $value) {
      Permission::insertOrIgnore([
        "name"   => $key,
      ]);
    }
  }
}
