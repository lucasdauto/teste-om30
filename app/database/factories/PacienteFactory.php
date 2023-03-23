<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends Factory<Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'foto' => $this->faker->imageUrl(),
            'nome_completo' => $this->faker->name,
            'nome_mae' => $this->faker->name,
            'data_nascimento' => $this->faker->date,
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'cns' => $this->faker->numerify('##########'),
            'cep' => $this->faker->numerify('#####-###'),
            'logradouro' => $this->faker->streetName,
            'numero' => $this->faker->randomNumber(3),
            'complemento' => $this->faker->secondaryAddress,
            'bairro' => $this->faker->citySuffix,
            'cidade' => $this->faker->city,
            'estado' => $this->faker->stateAbbr,
        ];
    }
}
