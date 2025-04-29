<?php

namespace Database\Seeders;
use App\Models\Election;
use App\Models\ProcesVerbal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcesVerbalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $elections = Election::all();

    foreach ($elections as $election) {
        ProcesVerbal::create([
            'elections_id' => $election->id(),
            'contenu' => "Résultats de l'élection ".$election->title(),
            'date_generation' => now()
        ]);
    }
}
}
