<?php

namespace Database\Seeders;

use App\Models\Personnel;
use Illuminate\Database\Seeder;

class PersonnelSeeder extends Seeder
{
    public function run()
    {
        // Create 50 random personnel (mix of PER and PATS)
        Personnel::factory()->count(30)->per()->create([ 'grades_id' => null ]);
        // Pour les PATS (20)
        Personnel::factory()->count(20)->pats()->create();

        // Create specific admin user
        Personnel::factory()->create([
            'nom' => 'Admin',
            'prenom' => 'User',
            'email' => 'admin@exemple.com',
            'motDePasse' => bcrypt('admin123'),
            'type' => 'PER',
        ]);
    }
}