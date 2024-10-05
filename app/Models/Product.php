<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
            'barcode',
            'name', 
            'price', 
            'image_url', 
            'status', 
            'stock', 
            'tax_type_id', 
            'tax_percentage', 
            'doc_type_id', 
            'doc_number', 
            'institution_name', 
            'auth_date',
            'price_sell'
    ];

    // Relación con la tabla de tipos de impuestos
    public function taxType()
    {
        return $this->belongsTo(TaxType::class);
    }

    public function taxTypeEdit()
    {
        return $this->belongsTo(TaxType::class, 'tax_type_id_imp');
    }

    // Relación con la tabla de tipos de documentos exonerados
    public function docType()
    {
        return $this->belongsTo(DocType::class);
    }
}
