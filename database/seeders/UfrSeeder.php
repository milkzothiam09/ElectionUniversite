<?php

namespace Database\Seeders;

use App\Models\Ufr;
use Illuminate\Database\Seeder;

class UfrSeeder extends Seeder
{
    public function run()
    {
        $ufrs = [
            ['name' => 'Sciences et Technologies', 'universite_id' => 1],
            ['name' => 'Lettres et Sciences Humaines', 'universite_id' => 1],
            ['name' => 'Droit', 'universite_id' => 1],
            ['name' => 'Médecine', 'universite_id' => 1],
        ];

        foreach ($ufrs as $ufr) {
            Ufr::create($ufr);
        }
    }
}