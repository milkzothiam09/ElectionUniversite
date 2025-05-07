<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Seeder;

class DepartementSeeder extends Seeder
{
    public function run()
    {
        $departements = [
            ['name' => 'Informatique', 'ufrs_id' => 1],
            ['name' => 'Mathématiques', 'ufrs_id' => 1],
            ['name' => 'Physique', 'ufrs_id' => 1],
            ['name' => 'Chimie', 'ufrs_id' => 1],
            ['name' => 'Lettres Modernes', 'ufrs_id' => 2],
            ['name' => 'Philosophie', 'ufrs_id' => 2],
            ['name' => 'Histoire', 'ufrs_id' => 2],
            ['name' => 'Droit Public', 'ufrs_id' => 3],
            ['name' => 'Droit Privé', 'ufrs_id' => 3],
            ['name' => 'Médecine Générale', 'ufrs_id' => 4],
        ];

        foreach ($departements as $departement) {
            Departement::create($departement);
        }
    }
}
