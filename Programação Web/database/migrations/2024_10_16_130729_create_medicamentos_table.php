<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicamentos', function (Blueprint $table) {
        $table->integer('referencia')->primary();
        $table->string('nome', 255);
        $table->float('preco', 2);
        $table->text('descricao');
        $table->string('forma');
        $table->string('dosagem');
        $table->string('imagem', 255)->nullabe();
        $table->integer('quantidade');
        $table->string('industria');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};
