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
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cb_origen_id');
            $table->decimal('monto', 8, 2);
            $table->string('descripcion');
            $table->date('fecha');
            $table->string('titular_cb_destino');
            $table->string('numero_cb_destino');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();
            $table->foreign('cb_origen_id')->references('id')->on('cuenta_bancaria');
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacciones');
    }
};
