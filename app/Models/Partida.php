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
        'concepto_partida', 
        'unidad_partida', 
        'cantidad_partida', 
        'pu_partida', 
        // ... otros campos ...
    ];
}
