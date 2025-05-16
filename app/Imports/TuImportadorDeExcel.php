<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Partida; // Reemplaza con el nombre de tu modelo

class TuImportadorDeExcel implements ToModel, WithHeadingRow
{
    protected $id_proyecto;
    public function __construct(int $id_proyecto)
    {
        $this->id_proyecto = $id_proyecto;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {        
        return new Partida([
            'concepto_partida' => $row['concepto'], // Asocia la columna del Excel con la columna de la BD
            'unidad_partida' => $row['unidad'],// Asocia la columna del Excel con la columna de la BD
            'cantidad_partida' => $row['cantidad'],// Asocia la columna del Excel con la columna de la BD
            'pu_partida' => $row['pu'],
            'id_proyecto' => $this->id_proyecto,
        ]);
    }

    /**
     * Define la fila de encabezado.
     *
     * @return int
     */
    public function headingRow(): int
    {
        return 1; // Asume que la primera fila de tu Excel contiene los encabezados
    }
}