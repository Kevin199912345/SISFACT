<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionesDetails extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones_datails';
    protected $primaryKey = 'id'; 

    // Definir los campos que se pueden asignar de forma masiva
    protected $fillable = [
        'cotizacion_id',
        'barcode',
        'description',
        'quantity',
        'precio_unitario',
        'discount',
        'taxes',
        'total',
    ];

    /**
     * Relación con el modelo Cotizacion
     * Una cotización detalle pertenece a una cotización.
     */
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id', 'id');
    }
}
