<?php

namespace Database\Seeders;

use App\Models\Candidat;
use App\Models\Election;
use App\Models\User;
use Illuminate\Database\Seeder;

class CandidatSeeder extends Seeder
{
    public function run()
    {
        $election1 = Election::find(1);
        $election2 = Election::find(2);
        $election3 = Election::find(3);

        // Candidats pour l'élection 1 (chef département)
        $perUsers = User::where('type', 'PER')->where('departement_id', 1)->take(3)->get();
        foreach ($perUsers as $user) {
            Candidat::create([
                'users_id' => $user->id,
                'elections_id' => $election1->id,
                'status' => 'approuvé',
                'motivation' => 'Je souhaite contribuer au développement du département'
            ]);
        }

        // Candidats pour l'élection 2 (directeur UFR)
        $perUsers = User::where('type', 'PER')->where('ufrs_id', 1)->take(3)->get();
        foreach ($perUsers as $user) {
            Candidat::create([
                'users_id' => $user->id,
                'elections_id' => $election2->id,
                'status' => 'approuvé',
                'motivation' => 'Vision pour l\'UFR Sciences'
            ]);
        }

        // Candidats pour l'élection 3 (vice-recteur)
        $perUsers = User::where('type', 'PER')->take(4)->get();
        foreach ($perUsers as $user) {
            Candidat::create([
                'users_id' => $user->id,
                'elections_id' => $election3->id,
                'status' => 'approuvé',
                'motivation' => 'Projet pour l\'université'
            ]);
        }
    }
}
