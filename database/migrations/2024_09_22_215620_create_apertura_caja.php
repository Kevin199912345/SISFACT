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
        Schema::create('apertura_caja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_caja'); 
            $table->foreign('id_caja')->references('id')->on('caja')->onDelete('cascade');
            $table->decimal('monto_apertura', 16, 2);
            $table->decimal('monto_cierre', 16, 2)->nullable();;
            $table->unsignedBigInteger('id_user_apertura'); 
            $table->foreign('id_user_apertura')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apertura_caja');
    }
};
