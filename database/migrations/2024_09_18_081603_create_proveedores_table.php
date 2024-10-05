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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('type_id', 2);
            $table->string('id_number')->unique();
            $table->string('direccion')->nullable();
            $table->string('phone', 20);
            $table->string('email', 255)->unique();
            $table->string('contacto', 255)->nullable();
            $table->string('phone_contacto', 20)->nullable();
            $table->tinyInteger('status')->default(1); // Activo por defecto
            $table->string('metodo_pago', 50)->nullable();
            $table->string('cuenta_bancaria', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
