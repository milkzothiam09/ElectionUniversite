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
            'name' => 'Université de Thiès',
            'acronym' => 'UT',
            'city' => 'Thiès',
            'country' => 'Sénégal'
        ]);

        Universite::create([
            'name' => 'Université Cheikh Anta Diop',
            'acronym' => 'UCAD',
            'city' => 'Dakar'
        ]);
        Universite::create([
            'name' => 'Université de Sédhiou',
            'acronym' => 'US',
            'city' => 'Sédhiou',
            'country'=>'Sénégal'
        ]);
        Universite::create([
            'name' => 'Université de Kara',
            'acronym' => 'UK',
            'city' => 'Tamba',
            'country'=>'Sénégal'
        ]);
        Universite::create([
            'name' => 'Université de Ziguinchor',
            'acronym' => 'UZ',
            'city' => 'Ziguinchor',
            'country'=>'Sénégal'
        ]);
        Universite::create([
            'name' => 'Université de Bambey',
            'acronym' => 'UB',
            'city' => 'Bambey',
            'country'=>'Sénégal'
        ]);

        Universite::create([
            'name' => 'Université de Gaston Berger',
            'acronym' => 'UGB',
            'city' => 'Saint-Louis',
            'country'=>'Sénégal'
        ]);
    }
}
