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
            'address' => '',
            'city' => 'Thiès',
            'country' => 'Sénégal'
        ]);

        Universite::create([
            'name' => 'Université Cheikh Anta Diop',
            'acronym' => 'UCAD',
            'address' => '',
            'city' => 'Dakar',
            'country' => 'Sénégal'
            
        ]);
        Universite::create([
            'name' => 'Université de Sédhiou',
            'acronym' => 'US',
            'address' => '',
            'city' => 'Sédhiou',
            'country'=>'Sénégal'
        ]);
        Universite::create([
            'name' => 'Université de Kara',
            'acronym' => 'UK',
            'address' => '',
            'city' => 'Tamba',
            'country'=>'Sénégal'
        ]);
        Universite::create([
            'name' => 'Université de Ziguinchor',
            'acronym' => 'UZ',
            'address' => '',
            'city' => 'Ziguinchor',
            'country'=>'Sénégal'
        ]);
        Universite::create([
            'name' => 'Université de Bambey',
            'acronym' => 'UADB',
            'address' => '',
            'city' => 'Bambey',
            'country'=>'Sénégal'
        ]);

        Universite::create([
            'name' => 'Université de Gaston Berger',
            'acronym' => 'UGB',
            'address' => '',
            'city' => 'Saint-Louis',
            'country'=>'Sénégal'
        ]);
    }
}
