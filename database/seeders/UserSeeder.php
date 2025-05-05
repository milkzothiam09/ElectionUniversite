<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(){
        // Create admin user


      $email = 'admin@univ.edu';

      if (User::where('email', $email)->doesntExist()) {
         User::create([
         'name' => 'Admin',
         'email' => $email,
         'password' => bcrypt('password'),
         'type' => 'PER',
         'grades_id' => 4,
         'departements_id' => 1,
         'ufrs_id' => 1,
          ]);
    } else {
    // L'email existe déjà
        echo "L'utilisateur avec cet email existe déjà.";
    }


        // Create PER users
        for ($i = 1; $i <= 20; $i++) {
            $user = User::firstOrCreate([
                'name' => 'PER User ' . $i,
                'email' => 'per' . $i . '@univ.edu',
                'password' => Hash::make('password'),
                'type' => 'PER',
                'grades_id' => rand(1, 4),
                'departements_id' => rand(1, 10),
                'ufrs_id' => rand(1, 4)
            ]);
            $user->assignRole('per');

        for ($i = 0; $i <= 20; $i++) {
            $user = User::firstOrCreate([
                'name' => 'PER User ' . $i,
                'email' => 'per' . $i . '@univ.edu',
                'password' => Hash::make('password'),
                'type' => 'PER',
                'grades_id' => rand(1, 4),
                'departements_id' => rand(1, 10),
                'ufrs_id' => rand(1, 4)
            ]);
            $user->assignRole('per');
        }

        // Create PATS users
        for ($i = 1; $i <= 10; $i++) {
            $user = User::firstOrCreate([
                'name' => 'PATS User ' . $i,
                'email' => 'pats' . $i . '@univ.edu',
                'password' => Hash::make('password'),
                'type' => 'PATS',
                'departements_id' => rand(1, 10),
                'ufrs_id' => rand(1, 4)
            ]);
            $user->assignRole('pats');
        }
    }
 }
}
