<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use App\Models\Compra;

class CompraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Teste
        // Compra::factory()->count(10)->create();
        DB::table('compras')->insert([
            [
                'id' => 1,
                'total' => 44.30,
                'data' => '2024-10-22',
                'user_email' => 'miguel@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'total' => 137.70,
                'data' => '2024-11-22',
                'user_email' => 'miguel@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'total' => 103.20,
                'data' => '2024-12-22',
                'user_email' => 'user2@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]]);
    }
}

