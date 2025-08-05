@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1>Editar Elemento Catalogo</h1>
          </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Editar Partida</h4>
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
                    Catalogo
                  </div>
                </div>
              </div>
            </div>
          </div>

          <form method="POST" action="{{ route('guardar.editarpartida')}}" class="wizard-content mt-2">
                @csrf
            <div class="wizard-pane">
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">NO</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="no_partida" value="{{$partida->no_partida}}" class="form-control">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">CONCEPTO</label>
                <div class="col-lg-4 col-md-6">
                  <textarea class="form-control" name="concepto_partida">{{$partida->concepto_partida}}</textarea>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">UNIDAD</label>
                <div class="col-lg-4 col-md-6">
                  <select class="form-control" name="unidad_partida">
                    <option value="0">Selecciona una Unidad</option>
                      @if($partida->unidad_partida=="KG")
                        <option value="KG" selected>KG</option>
                      @else
                        <option value="KG">KG</option>
                      @endif
                      @if($partida->unidad_partida=="M2")
                        <option value="M2" selected>M2</option>
                      @else
                        <option value="M2">M2</option>
                      @endif
                      @if($partida->unidad_partida=="M3")
                        <option value="M3" selected>M3</option>
                      @else
                        <option value="M3">M3</option>
                      @endif
                      @if($partida->unidad_partida=="ML")
                        <option value="ML" selected>ML</option>
                      @else
                        <option value="ML">ML</option>
                      @endif
                      @if($partida->unidad_partida=="PZA")
                        <option value="PZA" selected>PZA</option>
                      @else
                        <option value="PZA">PZA</option>
                      @endif
                  </select>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">CANTIDAD</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="cantidad_partida" value="{{$partida->cantidad_partida}}" class="form-control">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">P.U.</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="pu_partida" value="{{$partida->pu_partida}}" class="form-control">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">P.U. CONTRATISTA</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="pu_contratista_partida" value="{{$partida->pu_contratista_partida}}" class="form-control">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-4"></div>
                <div class="col-lg-4 col-md-6 text-right">
                  <input type="hidden" name="id_partida" value="{{$partida->id_partida}}" class="form-control">
                  <input type="hidden" name="id_proyecto" value="{{$partida->id_proyecto}}" class="form-control">
                  <button type="button" class="btn btn-secondary ms-2" onclick="history.back()">
                      <i class="fas fa-arrow-left"></i> Volver
                  </button>
                  <button type="submit" class="btn btn-danger ms-2">
                      <i class="fas fa-save"></i> Guardar
                  </button>
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