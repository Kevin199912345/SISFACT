<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperturaCaja extends Model
{
    use HasFactory;

    protected $table = 'apertura_caja';
    protected $primaryKey = 'id'; 


    protected $fillable = [
        'id_caja',
        'monto_apertura',
        'monto_cierre',
        'id_user_apertura',
        'status'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user_apertura', 'id');
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja', 'id');
    }
}
