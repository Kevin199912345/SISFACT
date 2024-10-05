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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('type_id', 2);
            $table->string('id_number'); // Número de identificación
            $table->string('name'); // Nombre o Razón Social
            $table->string('commercial_name')->nullable(); // Nombre Comercial
            $table->date('fecha_nacimiento')->nullable();
            $table->string('phone')->nullable(); // Teléfono
            $table->string('fax')->nullable(); // Fax
            $table->string('province'); // Provincia
            $table->string('canton'); // Cantón
            $table->string('district'); // Distrito
            $table->string('barrio')->nullable(); // Barrio
            $table->string('other_signs')->nullable(); // Otras señas
            $table->string('email')->nullable(); // Correo electrónico
            $table->boolean('status')->default(1);
            $table->timestamps(); // Crear columnas de created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
