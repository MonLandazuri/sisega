<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contratista extends Model
{
     use HasFactory;
     
    protected $primaryKey = 'id_contratista';

    protected $table = 'contratistas';
    protected $fillable = [
        'nombre_contratista', 
        'direccion_contratista', 
        'banco_contratista', 
        'tarjeta_contratista',
        'clabe_contratista',
        'cuenta_contratista',
    ];
    
    public function archivos()
    {
        return $this->hasMany(ContratistaArchivo::class);
    }

    public function ordenesDeCompra()
    {
        return $this->hasMany(Ordenes::class, 'id_contratista'); // Asegúrate que 'id_contratista' es la FK en tu tabla de OCs
    }
}
