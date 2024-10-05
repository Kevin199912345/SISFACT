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
        Schema::create('cotizaciones_datails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cotizacion_id'); 
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onDelete('cascade');
            $table->string('description');
            $table->integer('quantity');
            $table->decimal('precio_unitario', 16, 2);
            $table->decimal('discount', 5, 2)->default(0);
            $table->decimal('taxes', 5, 2);
            $table->decimal('total', 16, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones_datails');
    }
};
