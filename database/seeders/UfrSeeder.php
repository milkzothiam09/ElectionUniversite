<?php

namespace Database\Seeders;

use App\Models\Ufr;
use Illuminate\Database\Seeder;

class UfrSeeder extends Seeder
{
    public function run()
    {
        $ufrs = [
            ['name' => 'Sciences et Technologies', 'universites_id' => 1],
            ['name' => 'Lettres et Sciences Humaines', 'universites_id' => 1],
            ['name' => 'Droit', 'universites_id' => 1],
            ['name' => 'Médecine', 'universites_id' => 1],
        ];

        foreach ($ufrs as $ufr) {
            Ufr::create($ufr);
        }
    }
}