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
        Schema::table('products', function (Blueprint $table) {
            $table->string('unidad_medida', 10)->default('Unid');
            $table->string('tipo_producto', 20);
            $table->text('descripcion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('unidad_medida');
            $table->dropColumn('tipo_producto');
            $table->dropColumn('descripcion')->nullable();
            $table->string('categoria')->nullable();
            $table->string('codigo_hacienda')->nullable();
        });
    }
};
