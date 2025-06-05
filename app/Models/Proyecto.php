<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    
    protected $table = 'proyectos';
    protected $fillable = [
        'nombre_proyecto', 
        'dependencia_proyecto', 
        'constructora_proyecto', 
        'fecha_proyecto', 
        'status_proyecto',
    ];

    public $timestamps = false; 

}
