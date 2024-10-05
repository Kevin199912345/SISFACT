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
        Schema::create('caja', function (Blueprint $table) {
            $table->id();
            
            // Cambiar a unsignedBigInteger para que coincida con el tipo de la clave primaria de la tabla sucursal
            $table->unsignedBigInteger('sucursal_id'); 
            
            // Relación con la tabla sucursal (nombre correcto y tipo de dato adecuado)
            $table->foreign('sucursal_id')->references('id')->on('sucursal')->onDelete('cascade');
            
            $table->string('codigo_caja')->unique(); // Código único de caja para Hacienda
            $table->string('name', 255); // Nombre o descripción de la caja
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja');
    }
};
