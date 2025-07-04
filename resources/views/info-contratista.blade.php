@extends('layouts.master')

@section('content')
<section class="section">
  <div class="section-header">
    <h1></h1>
  </div>
  <div class="row">          
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    </div>
  </div>

  
  <div class="row">
    <div class="col-12">
      <div class="card">      
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
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Archivos de Contratista</h4>
            </div>
            <div class="card-body">
              <form action="#" class="dropzone dz-clickable" id="mydropzone">
                
              <div class="dz-default dz-message"><span>Arrastrar documentos</span></div></form>
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
<script src="assets/js/page/components-multiple-upload.js"></script>
@endsection()