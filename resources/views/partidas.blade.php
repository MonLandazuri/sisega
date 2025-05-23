@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1>Catálogo</h1>
          </div>
          <div class="row">          
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Proyectos</h4>
                  </div>
                  <div class="card-body">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Proyectos Activos</h4>
                  </div>
                  <div class="card-body">
                  </div>
                </div>
              </div>
            </div> 
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Cancelados</h4>
                  </div>
                  <div class="card-body">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-dark">
                  <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Finalizados</h4>
                  </div>
                  <div class="card-body">
                  </div>
                </div>
              </div>
            </div>       
          </div>

  <div class="row">
                  
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <a href="{{ route('import.form', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-icon icon-left btn-dark" data-toggle="tooltip" title=""><i class="far fa-file"></i> Importar Excel</a>
          <a href="{{ route('import.form', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-icon icon-left btn-dark" data-toggle="tooltip" title=""><i class="far fa-file"></i> Importar Excel</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-partidas" id="table-1">
              <thead>                                 
                <tr>
                  <th class="text-center col-id">
                    #
                  </th>
                  <th class="col-concepto">Concepto</th>
                  <th class="col-unidad">Unidad</th>
                  <th class="col-cantidad">Cantidad</th>
                  <th class="col-pu">PU</th>
                  <th class="col-importe">Importe</th>
                </tr>
              </thead>
              <tbody>   
              @if ($partidas->count() > 0)  
                @foreach ($partidas as $partida)                              
                <tr>
                  <td data-order="{{$partida->id_partida}}">
                    {{ $partida->no_partida }}
                  </td>
                  <td>
                    {{ $partida->concepto_partida }}
                  </td>
                  <td>
                    {{ $partida->unidad_partida }}
                  </td>
                  <!--<td class="align-middle">
                    <div class="progress" data-height="4" data-toggle="tooltip" title="100%">
                      <div class="progress-bar bg-success" data-width="100%"></div>
                    </div>
                  </td>-->
                  <td>
                    {{ $partida->cantidad_partida }}
                  </td>
                  <td>
                    ${{ number_format($partida->pu_partida,2) }}
                  </td>
                  <td>
                    ${{ number_format($partida->cantidad_partida*$partida->pu_partida,2) }}
                  </td>
                </tr>
                @endforeach 
                @else
                    <p>No hay partidas disponibles.</p>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .table-partidas .col-id{
    width: 5% !important;
  }
  .table-partidas .col-concepto{
    width: 60% !important;
  }
  .table-partidas .col-unidad{
    width: 5% !important;
  }
  .table-partidas .col-cantidad{
    width: 10% !important;
  }
  .table-partidas .col-pu{
    width: 10% !important;
  }
  .table-partidas .col-importe{
    width: 20% !important;
  }
</style>
@endsection()