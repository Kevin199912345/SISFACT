<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'id'; 


    protected $fillable = [
        'type_id',
        'name',
        'id_number',
        'commercial_name',
        'fecha_nacimiento',
        'phone',
        'email',
        'province',
        'canton',
        'district',
        'barrio',
        'other_signs',
        'status',
        'fax'];
}
