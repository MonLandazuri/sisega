@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1>Partidas</h1>
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
    <a href="{{ route('import.form', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-dark btn-action mr-1" data-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></a>
                    
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4></h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table-1">
              <thead>                                 
                <tr>
                  <th class="text-center">
                    #
                  </th>
                  <th>Concepto</th>
                  <th>Unidad</th>
                  <th>Cantidad</th>
                  <th>PU</th>
                </tr>
              </thead>
              <tbody>   
              @if ($partidas->count() > 0)  
                @foreach ($partidas as $partida)                              
                <tr>
                  <td>
                    {{ $partida->id_partida }}
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
                  <td><div class="badge badge-success">
                    {{ $partida->pu_partida }}
                  </div></td>
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
@endsection()