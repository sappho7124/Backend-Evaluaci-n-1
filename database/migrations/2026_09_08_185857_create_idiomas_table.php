<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idiomas', function (Blueprint $table) {
            $table->id(); // INT AUTO_INCREMENT PRIMARY KEY (BIGINT por defecto en Laravel)
            $table->string('nombre', 50);
            $table->string('codigo', 5);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idiomas');
    }
};
?>