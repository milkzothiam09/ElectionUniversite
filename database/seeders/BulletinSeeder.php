<?php

namespace Database\Seeders;
use App\Models\Election;
use App\Models\User;
use App\Models\Bulletin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulletinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $elections = Election::all();

    foreach ($elections as $election) {
        $users = User::inRandomOrder()->take(10)->get();

        foreach ($users as $user) {
            if ($user->verifierDroitVote($election)) {
                Bulletin::create([
                    'elections_id' => $election->id(),
                    'users_id' => $user->id(),
                    'choix' => rand(0, 1) ? 'pour' : 'null',
                    'date_vote' => now()
                ]);
            }
        }
    }
}
}
