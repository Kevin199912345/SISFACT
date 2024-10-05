<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $table = 'caja';
    protected $primaryKey = 'id'; 


    protected $fillable = [
        'sucursal_id',
        'codigo_caja',
        'name',
        'status'];

        public function sucursal()
        {
            return $this->belongsTo(Sucursal::class);
        }

        public function aperturaCajas()
        {
            return $this->hasMany(AperturaCaja::class, 'id_caja', 'id');
        }
}
