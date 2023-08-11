<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    User::insertOrIgnore([
      'name' => 'Bashar',
      'email' => 'bashar@gmail.com',
      'password' => Hash::make('123456789'),
      'is_verified' => true,
      'phone' => '+9639' . $this->generateNumbers(8),
      'role_id' => Role::first()->id,
    ]);
  }

  public function generateNumbers($strength = 3)
  {
    $permitten_chars = '0123456789';
    $input_length = strlen($permitten_chars);
    $random_string = '';

    for ($i = 0; $i < $strength; $i++) {
      $random_characters = $permitten_chars[mt_rand(0, $input_length - 1)];
      $random_string .= $random_characters;
    }

    return $random_string;
  }
}
