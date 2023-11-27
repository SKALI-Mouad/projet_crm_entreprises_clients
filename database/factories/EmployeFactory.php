<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employe>
 */
class EmployeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_employe' => fake()->lastName(),
            'prenom_employe' => fake()->firstName(),
            'sexe_employe' => ["Masculin", "Feminin"][rand(0,1)],
            'numero_telephone_employe' => fake()->e164PhoneNumber(),
            'email_employe' => fake()->unique()->safeEmail(),
            'is_verified' => rand(0,1),
            'entreprise_id' => rand(1,3),
        ];
    }
}
