@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1>Proyectos</h1>
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
                    {{ $totalProyectos}}
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
                    {{$totalProyectosActivos}}
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
                    {{$totalProyectosCancelados}}
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
                    {{$totalProyectosFinalizados}}
                  </div>
                </div>
              </div>
            </div>       
          </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Proyectos</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table-1">
              <thead>                                 
                <tr>
                  <th class="text-center">
                    #
                  </th>
                  <th>Nombre</th>
                  <th>Dependencia</th>
                  <th>Fecha</th>
                  <th>Status</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody>   
              @if ($proyectos->count() > 0)  
                @foreach ($proyectos as $proyecto)                              
                <tr>
                  <td>
                    {{ $proyecto->id_proyecto }}
                  </td>
                  <td>
                    {{ $proyecto->nombre_proyecto }}
                  </td>
                  <td>
                    <a href="#" class="font-weight-600">{{ $proyecto->dependencia_proyecto }}</a>
                  </td>
                  <!--<td class="align-middle">
                    <div class="progress" data-height="4" data-toggle="tooltip" title="100%">
                      <div class="progress-bar bg-success" data-width="100%"></div>
                    </div>
                  </td>-->
                  <td>
                    {{ $proyecto->fecha_proyecto }}
                  </td>
                  <td><div class="badge badge-success">
                    {{ $proyecto->status_proyecto }}
                  </div></td>
                  <td>
                    <a class="btn btn-dark btn-action mr-1" data-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></a>
                    <a class="btn btn-danger btn-action mr-1" data-toggle="tooltip" title="Cancelar" data-confirm="¿Quieres Cancelar el Proyecto?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
                    <a class="btn btn-danger btn-action mr-1" data-toggle="tooltip" title="Finalizar" data-confirm="¿Quieres Finalizar el Proyecto?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>

                  </td>
                </tr>
                @endforeach 
                @else
                    <p>No hay proyectos disponibles.</p>
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