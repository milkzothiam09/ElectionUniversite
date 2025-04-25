<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Seeder;

class DepartementSeeder extends Seeder
{
    public function run()
    {
        $departements = [
            ['name' => 'Informatique', 'ufr_id' => 1],
            ['name' => 'Mathématiques', 'ufr_id' => 1],
            ['name' => 'Physique', 'ufr_id' => 1],
            ['name' => 'Chimie', 'ufr_id' => 1],
            ['name' => 'Lettres Modernes', 'ufr_id' => 2],
            ['name' => 'Philosophie', 'ufr_id' => 2],
            ['name' => 'Histoire', 'ufr_id' => 2],
            ['name' => 'Droit Public', 'ufr_id' => 3],
            ['name' => 'Droit Privé', 'ufr_id' => 3],
            ['name' => 'Médecine Générale', 'ufr_id' => 4],
        ];

        foreach ($departements as $departement) {
            Departement::create($departement);
        }
    }
}