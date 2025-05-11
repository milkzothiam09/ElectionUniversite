<?php

namespace Database\Factories;

use App\Models\Bulletin;
use App\Models\Election;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BulletinFactory extends Factory
{
    protected $model = Bulletin::class;

    public function definition()
    {
        return [
            'id' => $this->fake()->uuid(),
            'elections_id' => Election::factory(),
            'users_id' => User::factory(),
            'choix' => $this->faker->randomElement(['pour', 'null']),
            'date_vote' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function pour()
    {
        return $this->state(function (array $attributes) {
            return [
                'choix' => 'pour',
            ];
        });
    }

    public function nul()
    {
        return $this->state(function (array $attributes) {
            return [
                'choix' => 'null',
            ];
        });
    }

    public function pourElection($electionId)
    {
        return $this->state(function (array $attributes) use ($electionId) {
            return [
                'elections_id' => $electionId,
                'choix' => 'pour',
            ];
        });
    }
}


