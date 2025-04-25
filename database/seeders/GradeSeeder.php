<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run()
    {
        $grades = [
            'Assistant Titulaire',
            'Maître Assistant Titulaire',
            'Maître de Conférence Titulaire',
            'Professeur Titulaire'
        ];

        foreach ($grades as $grade) {
            Grade::create(['name' => $grade]);
        }
    }
}