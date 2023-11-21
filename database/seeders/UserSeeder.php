<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */


  public function run(): void
  {
    $admin = User::create([
      "name" => "Jennifer Manhice",
      "email" => "jenmanhice@gmail.com",
      "phone_number" => "+258866559111",
      "password" => Hash::make("@dmin12345")
    ]);

    $lecturer = User::create([
      "name" => "Norberto Boa",
      "email" => "nboa.26@gmail.com",
      "phone_number" => "+258846860612",
      "password" => Hash::make("@dmin12345")
    ]);

    $student = User::create([
      "name" => "Frank Amiel",
      "email" => "frankamiel.fa@gmail.com",
      "phone_number" => "+258862767001",
      "password" => Hash::make("@dmin12345")
    ]);


    $admin->assignRole('admin');
    $student->assignRole('student');
    $lecturer->assignRole('lecturer');
  }
}
