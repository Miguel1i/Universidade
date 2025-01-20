<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use App\Models\Carrinho;

class CarrinhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('carrinhos')->insert( [
                [
                    'user_email' => 'miguel@gmail.com',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_email' => 'user2@example.com',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
        ]);
        // Testar
        // Carrinho::factory()->count(10)->create();
    }
}
