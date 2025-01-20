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
        Schema::create('compras_has_medicamento', function (Blueprint $table) {
            $table->unsignedBigInteger('compra_id');
            $table->foreign('compra_id')
                ->references('id')
                ->on('compras')
                ->onDelete('cascade');
            $table->integer('medicamento_referencia');
            $table->foreign('medicamento_referencia')
                ->references('referencia')
                ->on('medicamentos')
                ->onDelete('cascade');
            $table->primary(['compra_id', 'medicamento_referencia']);
            $table->integer('quantidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras_has_medicamento');
    }
};
