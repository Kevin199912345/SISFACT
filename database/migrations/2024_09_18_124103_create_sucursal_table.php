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
        Schema::create('sucursal', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_sucursal')->unique(); // Código único de sucursal para Hacienda
            $table->string('name', 255); // Nombre de la sucursal
            $table->string('direccion')->nullable(); // Dirección de la sucursal
            $table->string('telefono')->nullable(); // Teléfono de la sucursal
            $table->string('email')->nullable(); // Email de la sucursal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursal');
    }
};
