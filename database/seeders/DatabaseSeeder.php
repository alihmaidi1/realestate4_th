<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();
    $this->call(CreateAllPermissionSeeder::class);
    $this->call(CreateAdminPermissionSeeder::class);
    $this->call(CreateAdminSeeder::class);
    $this->call(CountrySeeder::class);
    $this->call(CitySeeder::class);
    $this->call(AreaSeeder::class);
    $this->call(TypeSeeder::class);

    $this->call(InformationSeeder::class);
    // $this->call(PostSeeder::class);
  }
}
