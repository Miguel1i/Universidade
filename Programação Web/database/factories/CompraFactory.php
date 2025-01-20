<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Compra::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'total' => $this->faker->randomFloat(2, 10, 500),
            'data' => $this->faker->date(),
            'user_email' => User::factory()->create()->email,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
