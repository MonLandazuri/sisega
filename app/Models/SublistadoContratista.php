<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogo;
use App\Models\Extraordinario;
use App\Models\Contratista;

class SublistadoContratista extends Model
{
    protected $table = 'sublistados_contratistas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_contratista', 
        'id_proyecto', 
        'id_partida', 
        'id_extra', 
        'id_sub',
        'cantidad', 
        'monto'
    ];

    public function contratista()
    {
        return $this->belongsTo(Contratista::class,'id_contratista');
    }

    public function catalogo()
    {
        return $this->belongsTo(Catalogo::class);
    }

    public function extraordinario()
    {
        return $this->belongsTo(Extraordinario::class);
    }
}