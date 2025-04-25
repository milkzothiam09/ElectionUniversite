<?php

namespace Database\Seeders;

use App\Models\Universite;
use App\Models\University;
use Illuminate\Database\Seeder;

class UniversiteSeeder extends Seeder
{
    public function run()
    {
        Universite::create([
            'name' => 'Université de Lomé',
            'acronym' => 'UL',
            'city' => 'Lomé',
            'country' => 'Togo'
        ]);
    }
}