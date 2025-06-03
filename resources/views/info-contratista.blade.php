@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1>Contratistas</h1>
          </div>
          <div class="row">          
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Contratistas</h4>
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
          <h4></h4>
          <a href="{{ route('nuevo.contratista') }}" class="btn btn-icon btn btn-dark btn-action mr-1" data-toggle="tooltip" title=""><i class="far fa-id-card"></i> Nuevo</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-proyectos" id="table-1">
              <thead>                                 
                <tr>
                  <th class="text-center col-no">#</th>
                  <th class="col-nombre">NOMBRE</th>
                  <th class="col-direccion">DIRECCIÓN</th>
                  <th class="col-banco">BANCO</th>
                  <th class="col-clabe">CLABE</th>
                  <th class="col-cuenta">CUENTA</th>
                  <th class="col-accion">ACCIONES</th>
                </tr>
              </thead>
              <tbody>   
              @if ($contratista->count() > 0)  
                @foreach ($contratista as $contra)                              
                <tr>
                  <td>
                    {{ $contra->id_contratista }}
                  </td>
                  <td>
                    {{ $contra->nombre_contratista }}
                  </td>
                  <td>
                    {{ $contra->direccion_contratista }}
                  </td>
                  <td>
                    {{ $contra->banco_contratista }}
                  </td>
                  <td>
                        {{ strtoupper($contra->clabe_contratista) }}
                  </td>
                  <td>
                        {{ strtoupper($contra->cuenta_contratista) }}
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-danger">Acciones</button>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(119px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="{{ route('info.contratista', ['id_contratista' => $contra->id_contratista]) }}">Ver</a>
                        <a class="dropdown-item" title="Eliminar" data-confirm="¿Quieres eliminar el Contratista?" data-confirm-yes="alert('Deleted')"  href="#">Eliminar</a>
                      </div>
                      <!--<div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(119px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="{{ route('contratistas') }}">Ver</a>
                        <a class="dropdown-item" title="Cancelar" data-confirm="¿Quieres cancelar el Proyecto?" data-confirm-yes="alert('Deleted')"  href="#">Cancelar</a>
                        <a class="dropdown-item" title="Finalizar" data-confirm="¿Quieres finalizar el Proyecto?" data-confirm-yes="alert('Deleted')" href="#">Finalizar</a>
                      </div>-->
                    </div>
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
<style>
  .table-proyectos .col-no{
    width: 5% !important;
  }
  .table-proyectos .col-nombre{
    width: 20% !important;
  }
  .table-proyectos .col-direccion{
    width: 30% !important;
  }
  .table-proyectos .col-banco{
    width: 15% !important;
  }
  .table-proyectos .col-clave{
    width: 15% !important;
  }
  .table-proyectos .col-cuenta{
    width: 15% !important;
  }
  .table-proyectos .col-accion{
    width: 15% !important;
  }
</style>
@endsection()