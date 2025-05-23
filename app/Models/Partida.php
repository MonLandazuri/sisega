<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;
    //
    protected $table = 'partidas';
    protected $fillable = [
        'no_partida',
        'concepto_partida', 
        'unidad_partida', 
        'cantidad_partida', 
        'pu_partida', 
        'id_proyecto',
        // ... otros campos ...
    ];
}
