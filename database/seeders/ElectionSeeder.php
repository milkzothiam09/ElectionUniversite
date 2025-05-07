<?php

namespace Database\Seeders;

use App\Models\Election;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ElectionSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // Chef de département élection
        Election::create([
            'title' => 'Élection Chef Département Informatique',
            'description' => 'Élection du chef du département d\'informatique pour le mandat 2023-2026',
            'type' => 'chef_departement',
            'start_date' => $now->copy()->addDays(7),
            'end_date' => $now->copy()->addDays(14),
            'candidature_start' => $now,
            'candidature_end' => $now->copy()->addDays(5),
            'status' => 'candidature',
            'departement_id' => 1
        ]);

        // Directeur UFR élection
        Election::create([
            'title' => 'Élection Directeur UFR Sciences',
            'description' => 'Élection du directeur de l\'UFR Sciences et Technologies',
            'type' => 'directeur_ufr',
            'start_date' => $now->copy()->addDays(10),
            'end_date' => $now->copy()->addDays(17),
            'candidature_start' => $now,
            'candidature_end' => $now->copy()->addDays(7),
            'status' => 'candidature',
            'ufr_id' => 1
        ]);

        // Vice-Recteur élection
        Election::create([
            'title' => 'Élection Vice-Recteur',
            'description' => 'Élection du vice-recteur de l\'université',
            'type' => 'vice_recteur',
            'start_date' => $now->copy()->addDays(14),
            'end_date' => $now->copy()->addDays(21),
            'candidature_start' => $now,
            'candidature_end' => $now->copy()->addDays(10),
            'status' => 'candidature'
        ]);
    }
}