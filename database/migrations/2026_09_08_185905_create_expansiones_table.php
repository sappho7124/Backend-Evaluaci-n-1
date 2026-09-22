<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expansiones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);

            // FOREIGN KEY (juego_id) REFERENCES juegos(id) ON DELETE CASCADE
            $table->foreignId('juego_id')
                  ->constrained('juegos')
                  ->onDelete('cascade');

            // FOREIGN KEY (idioma_id) REFERENCES idiomas(id)
            $table->foreignId('idioma_id')->constrained('idiomas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expansiones');
    }
};
?>