<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    // Definir los campos que se pueden llenar (mass assignable)
    protected $fillable = [
        'name', 
        'type_id', 
        'id_number', 
        'direccion', 
        'phone', 
        'email', 
        'contacto', 
        'phone_contacto', 
        'status', 
        'metodo_pago', 
        'cuenta_bancaria'
    ];
}
