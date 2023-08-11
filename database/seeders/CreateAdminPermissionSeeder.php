<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateAdminPermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // ### To Remove All Records From Table roles ###
    // Role::truncate();  // OR
    DB::table('roles')->delete(); // dont need this if used insertOrIgnore method

    $role = Role::create(['name' => "Super Admin"]);
    $all_permissions = Config("global.permissions");
    $role->permissions()->attach(range(1, count($all_permissions)));
  }
}
