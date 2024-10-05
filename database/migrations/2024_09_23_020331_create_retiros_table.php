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
        Schema::create('retiros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_apertura'); 
            $table->foreign('id_apertura')->references('id')->on('apertura_caja')->onDelete('cascade');
            $table->decimal('monto', 16, 2);
            $table->string('motivo', 255)->nullable();
            $table->unsignedBigInteger('id_user_retiro'); 
            $table->foreign('id_user_retiro')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retiros');
    }
};
