<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use App\Models\CarrinhoHasMedicamento;

class CarrinhoHasMedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CarrinhoHasMedicamento::factory()->count(10)->create();

        DB::table('carrinho_has_medicamentos')->insert([
            [
                'user_email' => 'miguel@gmail.com',
                'medicamento_referencia' => '1001',
                'quantidade' => 2,
            ],
            [
                'user_email' => 'miguel@gmail.com',
                'medicamento_referencia' => '1002',
                'quantidade' => 1,
            ],
            [
                'user_email' => 'user2@example.com',
                'medicamento_referencia' => '1003',
                'quantidade' => 3,
            ],
        ]);
    }
}
