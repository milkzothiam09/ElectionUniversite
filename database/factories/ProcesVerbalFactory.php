<?php

namespace Database\Factories;

use App\Models\Election;
use App\Models\ProcesVerbal;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProcesVerbalFactory extends Factory
{
    protected $model = ProcesVerbal::class;

    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'elections_id' => Election::factory(),
            'contenu' => $this->generateContenu(),
            'date_generation' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    private function generateContenu()
    {
        $faker = \Faker\Factory::create();

        $contenu = "PROCÈS-VERBAL DE L'ÉLECTION\n\n";
        $contenu .= "Date: ".now()->format('d/m/Y')."\n";
        $contenu .= "Heure: ".now()->format('H:i')."\n\n";
        $contenu .= "Résultats:\n";
        $contenu .= "- Nombre total de votants: ".$faker->numberBetween(50, 200)."\n";
        $contenu .= "- Bulletins valides: ".$faker->numberBetween(40, 190)."\n";
        $contenu .= "- Bulletins nuls: ".$faker->numberBetween(1, 10)."\n\n";
        $contenu .= "Détail des résultats:\n";

        for ($i = 0; $i < 3; $i++) {
            $contenu .= "- Candidat ".$faker->lastName.": ".$faker->numberBetween(10, 100)." voix\n";
        }

        $contenu .= "\nSignature du président du bureau de vote:\n\n";
        $contenu .= $faker->name."\n";

        return $contenu;
    }

    public function forElection($electionId)
    {
        return $this->state(function (array $attributes) use ($electionId) {
            return [
                'elections_id' => $electionId,
            ];
        });
    }
}
