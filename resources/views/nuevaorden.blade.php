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
          <h4>Agregar Nueva Orden de Compra</h4>
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
                <label class="col-md-4 text-md-right text-left">Contratista</label>
                <div class="col-lg-4 col-md-6">
                  <select class="form-control" name="codigo_oc">
                    <option value="">Selecciona un contratista</option>
                    @foreach ($contratistas as $contratista)
                      <option value="{{ $contratista->id_contratista}}">
                          {{ $contratista->nombre_contratista }} 
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">Opción</label>
                <div class="col-lg-4 col-md-6">
                  <button class="btn btn-warning collapsed" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1">Catalogo</button>
                  <button class="btn btn-warning collapsed" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Extraordinarios</button>
                </div>
              </div>
              <div class="form-group row align-items-center multi-collapse collapse" id="multiCollapseExample1">
                  <label class="col-md-4 text-md-right text-left">Catalogo</label>
                  <div class="col-lg-4 col-md-6">
                    <select class="form-control" name="codigo_oc">
                      <option value="">Selecciona un elemento</option>
                      @foreach ($partidas as $partida)
                        <option value="{{ $partida->id_partida}}">
                            {{ $partida->no_partida." - ".$partida->concepto_partida }} 
                        </option>
                      @endforeach
                    </select>
                  </div>
              </div>
              <div class="form-group row align-items-center multi-collapse collapse" id="multiCollapseExample2">
                  <label class="col-md-4 text-md-right text-left">Extraordinarios</label>
                  <div class="col-lg-4 col-md-6">
                    <select class="form-control" name="codigo_oc">
                      <option value="">Selecciona un elemento</option>
                    @foreach ($extras as $extra)
                      <option value="{{ $extra->id_extra}}">
                          {{ $extra->no_extra." - ".$extra->concepto_extra }} 
                      </option>
                    @endforeach
                    </select>
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
                </div>
                <div class="col-lg-4 col-md-6 text-right">
                  <input type="submit" class="btn btn-icon icon-right btn-primary" value="Agregar">
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