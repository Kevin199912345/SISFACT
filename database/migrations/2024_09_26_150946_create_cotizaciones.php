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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cotizacion')->unique();
            $table->unsignedBigInteger('id_cliente'); 
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('terms')->nullable();
            $table->decimal('subtotal', 16, 2);
            $table->decimal('total_taxes', 16, 2);
            $table->decimal('total_discounts', 16, 2);
            $table->decimal('total', 16, 2);
            $table->enum('status', ['pendiente', 'aceptada', 'rechazada', 'expirada']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
