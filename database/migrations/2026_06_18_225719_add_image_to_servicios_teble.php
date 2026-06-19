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
    Schema::table('servicios', function (Blueprint $table) {
        // Añadimos la columna para guardar la ruta de la imagen
        $table->string('image_path')->nullable(); 
    });
}

public function down(): void
{
    Schema::table('servicios', function (Blueprint $table) {
        $table->dropColumn('image_path');
    });
}
};
