@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1></h1>
          </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4></h4>
        </div>
        <div class="card-body">
          <div class="row mt-4">
            <div class="col-12 col-lg-8 offset-lg-2">
              <div class="wizard-steps">
                <div class="wizard-step wizard-step-active">
                  <div class="wizard-step-icon">
                    <i class="far fa-user"></i>
                  </div>
                  <div class="wizard-step-label">
                    Orden de Compra
                  </div>
                </div>
              </div>
            </div>
          </div>

          <form method="POST" action="{{ route('agregar.nuevaoc')}}" class="wizard-content mt-2">
                @csrf
            <div class="wizard-pane"> 
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">Opción</label>
                <div class="col-lg-4 col-md-6">
                  <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link" id="home-tab4" data-toggle="tab" href="#catalogo_opc" role="tab" aria-controls="catalogo_opc" aria-selected="false">Catálogo</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#extra_opc" role="tab" aria-controls="extra_opc" aria-selected="false">Extraordinarios</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="tab-content no-padding" id="myTab2Content">
                <div class="tab-pane fade" id="catalogo_opc" role="tabpanel" aria-labelledby="home-tab4">
                  <div class="form-group row align-items-center">
                    <label class="col-md-4 text-md-right text-left">Catálogo</label>
                    <div class="col-lg-4 col-md-6">
                      <select class="form-control" name="codigo_oc_catalogo">
                        <option value="0">Selecciona un elemento</option>
                          @foreach ($partidas as $partida)
                          <option value="{{ $partida->id_partida }}">
                              {{ $partida->no_partida." - ".$partida->concepto_partida }} 
                          </option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="extra_opc" role="tabpanel" aria-labelledby="profile-tab4">
                  <div class="form-group row align-items-center">
                    <label class="col-md-4 text-md-right text-left">Extraordinarios</label>
                    <div class="col-lg-4 col-md-6">
                      <select class="form-control" name="codigo_oc_extra">
                        <option value="0">Selecciona un elemento</option>
                          @foreach ($extras as $extra)
                          <option value="{{ $extra->id_extra }}">
                              {{ $extra->no_extra." - ".$extra->concepto_extra }} 
                          </option>
                          @endforeach
                      </select>
                    </div>   
                  </div>  
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">Cantidad</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="cantidad_oc" class="form-control">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-4">
                  <input type="hidden" name="id_proyecto" class="form-control" value="{{$id_proyecto}}">
                  <input type="hidden" name="id_orden" class="form-control" value="{{$id_orden}}">
                </div>
                <div class="col-lg-4 col-md-6 text-right">
                  <button type="submit" class="btn btn-icon icon-right btn-dark">Agregar <i class="fa fa-angle-right"></i></button>
                  <a href="{{ route('proyecto.partidas', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-info icon-left" data-toggle="tooltip" title="Terminar"><i class="far fa-file"></i> Terminar</a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection()


