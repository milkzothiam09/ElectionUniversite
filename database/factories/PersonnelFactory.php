<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class PersonnelFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'motDePasse' => bcrypt('password'),
            'type' => $this->faker->randomElement(['PER', 'PATS']),
            'grades_id' => function () {
                return \App\Models\Grade::inRandomOrder()->first()->id ?? 
                       \App\Models\Grade::factory()->create()->id;
            },
            'departements_id' => function () {
                return \App\Models\Departement::inRandomOrder()->first()->id ?? 
                       \App\Models\Departement::factory()->create()->id;
            },
            'ufrs_id' => function () {
                return \App\Models\Ufr::inRandomOrder()->first()->id ?? 
                       \App\Models\Ufr::factory()->create()->id;
            },
            'remember_token' => Str::random(10),
        ];
    }

    public function per()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'PER',
                'grades_id' => null,
            ];
        });
    }

    public function pats()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'PATS',
            ];
        });
    }
}