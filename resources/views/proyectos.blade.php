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
                  <i class="far fa-building"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Proyectos</h4>
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
                    <h4>Activos</h4>
                  </div>
                  <div class="card-body">
                    {{$totalProyectosActivos}}
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
                  <h4></h4>
                </div>
                <div class="card-body">
                  <ul class="nav nav-tabs" id="myTab2" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active show" id="proyectos-activos" data-toggle="tab" href="#activos" role="tab" aria-controls="activos" aria-selected="true">ACTIVOS</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="proyectos-finalizados" data-toggle="tab" href="#finalizados" role="tab" aria-controls="finalizados" aria-selected="false">FINALIZADOS</a>
                    </li>
                  </ul>
                  <div class="tab-content tab-bordered" id="myTab3Content">
                    <div class="tab-pane fade active show" id="activos" role="tabpanel" aria-labelledby="activos">
                      <div class="table-responsive">
                        <table class="table table-striped table-proyectos" id="table-1">
                          <thead>                                 
                            <tr>
                              <th class="text-center col-no">#</th>
                              <th class="col-nombre">Nombre</th>
                              <th class="col-dependencia">Dependencia</th>
                              <th class="col-constructora">Constructora</th>
                              <th class="col-fecha">Fecha</th>
                              <th class="col-accion">Acción</th>
                            </tr>
                          </thead>
                          <tbody>   
                          @if ($proyectos->count() > 0)  
                            @foreach ($proyectosActivos as $proyecto)                              
                            <tr>
                              <td>
                                {{ $proyecto->id_proyecto }}
                              </td>
                              <td>
                                <a href="{{ route('proyecto.partidas', ['id_proyecto' => $proyecto->id_proyecto]) }}" class="font-weight-600">{{ $proyecto->nombre_proyecto }}</a>
                              </td>
                              <td>
                                {{ $proyecto->dependencia_proyecto }}
                              </td>
                              <td>
                                {{ $proyecto->constructora_proyecto }}
                              </td>
                              <!--<td class="align-middle">
                                <div class="progress" data-height="4" data-toggle="tooltip" title="100%">
                                  <div class="progress-bar bg-success" data-width="100%"></div>
                                </div>
                              </td>-->
                              <td>
                                {{ \Carbon\Carbon::parse($proyecto->fecha_proyecto)->format('d/m/Y') }}
                              </td>
                              <td>
                                <div class="btn-group">
                                  <button type="button" class="btn btn-danger">Acciones</button>
                                  <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(119px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" href="{{ route('proyecto.partidas', ['id_proyecto' => $proyecto->id_proyecto]) }}">Ver</a>
                                    <a href="#" class="dropdown-item" title="Finalizar" onclick="event.preventDefault(); confirmarFinalizar({{ $proyecto->id_proyecto }});">
                                        Finalizar
                                    </a>

                                    <form id="finalizar-form-{{ $proyecto->id_proyecto }}" action="{{ route('proyectos.finalizar', $proyecto->id_proyecto) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>

                                    <script>
                                        function confirmarFinalizar(proyectoId) {
                                            // Muestra una ventana de confirmación
                                            if (confirm('¿Quieres finalizar el Proyecto? Esta acción no se puede deshacer.')) {
                                                // Si el usuario confirma, envía el formulario
                                                document.getElementById('finalizar-form-' + proyectoId).submit();
                                            }
                                        }
                                    </script>

                                  </div>
                                </div>
                                <!--<a href="{{ route('proyecto.partidas', ['id_proyecto' => $proyecto->id_proyecto]) }}" class="btn btn-dark btn-action mr-1" data-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></a>
                                <a class="btn btn-danger btn-action mr-1" data-toggle="tooltip" title="Cancelar" data-confirm="¿Quieres Cancelar el Proyecto?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
                                <a class="btn btn-danger btn-action mr-1" data-toggle="tooltip" title="Finalizar" data-confirm="¿Quieres Finalizar el Proyecto?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>-->
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
                    <div class="tab-pane fade" id="finalizados" role="tabpanel" aria-labelledby="finalizados">
                      <div class="table-responsive">
                        <table class="table table-striped table-proyectos-finalizados" id="table-1">
                          <thead>                                 
                            <tr>
                              <th class="text-center col-no">#</th>
                              <th class="col-nombre">Nombre</th>
                              <th class="col-dependencia">Dependencia</th>
                              <th class="col-constructora">Constructora</th>
                              <th class="col-fecha">Fecha</th>
                              <th class="col-accion">Acción</th>
                            </tr>
                          </thead>
                          <tbody>   
                          @if ($proyectosFinalizados->count() > 0)  
                            @foreach ($proyectosFinalizados as $proyecto)                              
                            <tr>
                              <td>
                                {{ $proyecto->id_proyecto }}
                              </td>
                              <td>
                                <a href="{{ route('proyecto.partidas', ['id_proyecto' => $proyecto->id_proyecto]) }}" class="font-weight-600">{{ $proyecto->nombre_proyecto }}</a>
                              </td>
                              <td>
                                {{ $proyecto->dependencia_proyecto }}
                              </td>
                              <td>
                                {{ $proyecto->constructora_proyecto }}
                              </td>
                              <td>
                                {{ $proyecto->fecha_proyecto->format('d/m/Y') }}
                              </td>
                              <td>
                                <div class="btn-group">
                                    <a class="btn btn-info icon-left" href="{{ route('proyecto.partidas', ['id_proyecto' => $proyecto->id_proyecto]) }}"><i class="fas fa-eye"></i> Ver</a>
                                    <!--<a class="dropdown-item" title="Finalizar" data-confirm="¿Quieres finalizar el Proyecto?" data-confirm-yes="alert('Deleted')" href="#">Finalizar</a>-->
                                </div>
                                <!--<a href="{{ route('proyecto.partidas', ['id_proyecto' => $proyecto->id_proyecto]) }}" class="btn btn-dark btn-action mr-1" data-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></a>
                                <a class="btn btn-danger btn-action mr-1" data-toggle="tooltip" title="Cancelar" data-confirm="¿Quieres Cancelar el Proyecto?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
                                <a class="btn btn-danger btn-action mr-1" data-toggle="tooltip" title="Finalizar" data-confirm="¿Quieres Finalizar el Proyecto?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>-->
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
            </div>
          </div>

</section>
<style>
  .table-proyectos .col-no{
    width: 5% !important;
  }
  .table-proyectos .col-nombre{
    width: 25% !important;
  }
  .table-proyectos .col-dependencia{
    width: 25% !important;
  }
  .table-proyectos .col-constructora{
    width: 10% !important;
  }
  .table-proyectos .col-fecha{
    width: 10% !important;
  }
  .table-proyectos .col-status{
    width: 10% !important;
  }
  .table-proyectos .col-accion{
    width: 15% !important;
  }
</style>
@endsection()