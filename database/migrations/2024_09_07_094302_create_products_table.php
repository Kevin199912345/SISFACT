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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('name');
            $table->decimal('price', 16, 2);
            $table->boolean('status')->default(1);
            $table->string('image_url')->nullable();

            // Stock del producto
            $table->integer('stock')->default(0);

            // Foreign key para tipo de impuesto
            $table->BigInteger('tax_type_id_imp')->unsigned()->nullable();
            $table->foreign('tax_type_id_imp')->references('id')->on('tax_types');

            // Porcentaje de impuesto
            $table->decimal('tax_percentage', 5, 2)->nullable();

            // Foreign key para tipo de documento exonerado
            $table->BigInteger('doc_type_id_exo')->unsigned()->nullable();
            $table->foreign('doc_type_id_exo')->references('id')->on('doc_types_exone');

            // Número de documento
            $table->string('doc_number_exo')->nullable();

            // Nombre de la institución
            $table->string('institution_name_exo')->nullable();

            // Fecha de autorización
            $table->date('auth_date_exo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
