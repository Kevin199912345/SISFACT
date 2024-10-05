<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizaciones extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'numero_cotizacion',
        'id_cliente',
        'start_date',
        'end_date',
        'terms',
        'subtotal',
        'total_taxes',
        'total_discounts',
        'total',
        'status',
        'credito',
        'plazo'
    ];

    // Definir relaciones si es necesario
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function productos()
    {
        return $this->hasMany(CotizacionesDetails::class, 'cotizacion_id');
    }

}
