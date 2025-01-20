<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompraHasMedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('compra_has_medicamento')->insert([
            [
                'compra_id' => 1,
                'medicamento_referencia' => '1001',
                'quantidade' => 2,
            ],
            [
                'compra_id' => 1,
                'medicamento_referencia' => '1002',
                'quantidade' => 1,
            ],
            [
                'compra_id' => 2,
                'medicamento_referencia' => '1003',
                'quantidade' => 3,
            ],
            [
                'compra_id' => 3,
                'medicamento_referencia' => '1004',
                'quantidade' => 4,
            ]
        ]);
    }
}
