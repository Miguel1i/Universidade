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
        Schema::create('carrinhos_has_medicamentos', function (Blueprint $table) {
            $table->string('user_email', 255);
            $table->foreign('user_email')
                ->references('user_email')
                ->on('carrinhos')
                ->onDelete('cascade');
            $table->primary(['user_email', 'medicamento_referencia']);
            $table->integer('medicamento_referencia');
            $table->foreign('medicamento_referencia')
                ->references('referencia')
                ->on('medicamentos')
                ->onDelete('cascade');
            $table->integer('quantidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrinhos_has_medicamentos');
    }
};
