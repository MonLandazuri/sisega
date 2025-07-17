<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contratista extends Model
{
     use HasFactory;

    protected $table = 'contratistas';
    protected $fillable = [
        'nombre_contratista', 
        'direccion_contratista', 
        'banco_contratista', 
        'clabe_contratista',
        'cuenta_contratista',
    ];
    
    public function archivos()
    {
        return $this->hasMany(ContratistaArchivo::class);
    }
}
