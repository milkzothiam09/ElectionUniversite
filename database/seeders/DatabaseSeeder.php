<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            GradeSeeder::class,
            UniversiteSeeder::class,
            UfrSeeder::class,
            DepartementSeeder::class,
            UserSeeder::class,
            ElectionSeeder::class,
            CandidatSeeder::class,
        ]);
    }
}