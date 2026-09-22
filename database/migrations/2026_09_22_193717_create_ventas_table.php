<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_cliente', 150);
            $table->string('correo_cliente', 150);
            $table->string('numero_tarjeta', 20);
            $table->decimal('valor_total', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};