<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Carrinho;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarrinhoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Carrinho::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_email' => User::factory()->create()->email,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
