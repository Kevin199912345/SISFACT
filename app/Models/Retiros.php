<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retiros extends Model
{
    use HasFactory;

    protected $table = 'retiros';
    protected $primaryKey = 'id'; 


    protected $fillable = [
        'id_apertura',
        'monto',
        'motivo',
        'id_user_retiro',
        'status'];

        public function usuario()
        {
            return $this->belongsTo(User::class, 'id_user_retiro', 'id');
        }
    
        public function apertura()
        {
            return $this->belongsTo(AperturaCaja::class, 'id_apertura', 'id');
        }
}
