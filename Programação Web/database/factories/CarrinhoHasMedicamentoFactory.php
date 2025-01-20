<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Medicamento;
use App\Models\CarrinhoHasMedicamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarrinhoHasMedicamentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarrinhoHasMedicamento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_email' => User::factory()->create()->email,
            'medicamento_referencia' => Medicamento::factory()->create()->referencia,
            'quantidade' => $this->faker->numberBetween(1, 10),
        ];
    }
}
