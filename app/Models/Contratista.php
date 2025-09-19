<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SublistadoContratista;

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
        return $this->hasMany(Ordenes::class, 'id_contratista'); 
    }

    public function anticipos()
    {
        return $this->hasMany(Anticipo::class, 'id_contratista');
    }

    public function sublistados()
    {
        return $this->hasMany(SublistadoContratista::class, 'contratista_id');
    }
}
