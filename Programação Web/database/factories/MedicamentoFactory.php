<?php

namespace Database\Factories;

use App\Models\Medicamento;
use Illuminate\Database\Eloquent\Factories\Factory;


class MedicamentoFactory extends Factory
{
    protected $model = Medicamento::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'referencia' => $this->faker->unique()->numberBetween(1000, 9999),
            'nome' => $this->faker->word,
            'preco' => $this->faker->randomFloat(2, 1, 100),
            'descricao' => $this->faker->paragraph(1),
            'forma' => $this->faker->randomElement(['tablet', 'capsule', 'liquid', 'ointment']),
            'dosagem' => $this->faker->randomElement(['10mg', '100mg', '250mg', '500mg']),
            'imagem' => 'medicine-placeholder.svg',
            'quantidade' => $this->faker->numberBetween(1, 100),
            'industria' => $this->faker->company,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
