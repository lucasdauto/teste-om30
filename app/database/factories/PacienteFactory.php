<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
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
        $faker = new Faker();
        return [
            'nome_completo' => $faker->name,
            'nome_mae' => $faker->name,
            'data_nascimento' => $faker->date(),
            'cpf' => $faker->cpf,
            'cns' => $faker->numerify('###########'),
            'endereco_cep' => $faker->postcode,
            'endereco_logradouro' => $faker->streetName,
            'endereco_numero' => $faker->buildingNumber,
            'endereco_complemento' => $faker->secondaryAddress,
            'endereco_bairro' => $faker->streetSuffix,
            'endereco_cidade' => $faker->city,
            'endereco_estado' => $faker->stateAbbr,
        ];
    }
}
