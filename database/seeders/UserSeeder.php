<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@univ.edu',
            'password' => Hash::make('password'),
            'type' => 'PER',
            'grade_id' => 4,
            'departement_id' => 1,
            'ufr_id' => 1
        ]);
        $admin->assignRole('admin');

        // Create PER users
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => 'PER User ' . $i,
                'email' => 'per' . $i . '@univ.edu',
                'password' => Hash::make('password'),
                'type' => 'PER',
                'grade_id' => rand(1, 4),
                'departement_id' => rand(1, 10),
                'ufr_id' => rand(1, 4)
            ]);
            $user->assignRole('per');
        }

        // Create PATS users
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => 'PATS User ' . $i,
                'email' => 'pats' . $i . '@univ.edu',
                'password' => Hash::make('password'),
                'type' => 'PATS',
                'departement_id' => rand(1, 10),
                'ufr_id' => rand(1, 4)
            ]);
            $user->assignRole('pats');
        }
    }
}