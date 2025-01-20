<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\Medicamento;
use App\Models\CompraHasMedicamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraHasMedicamentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompraHasMedicamento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'compra_id' => Compra::factory(),
            'medicamento_referencia' => Medicamento::factory(),
            'quantidade' => $this->faker->numberBetween(1, 20),
        ];
    }
}
