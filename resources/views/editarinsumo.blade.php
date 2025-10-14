@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1>Editar Elemento Insumo</h1>
          </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Editar Insumo</h4>
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
                    Insumo
                  </div>
                </div>
              </div>
            </div>
          </div>

          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          <form method="POST" action="{{ route('guardar.editarinsumo')}}" class="wizard-content mt-2">
                @csrf
            <div class="wizard-pane">
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">NO</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="no_insumo" class="form-control" value="{{$insumo->no_insumo}}">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">CONCEPTO</label>
                <div class="col-lg-4 col-md-6">
                  <textarea class="form-control" name="concepto_insumo">{{$insumo->concepto_insumo}}</textarea>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">UNIDAD</label>
                <div class="col-lg-4 col-md-6">
                  <input list="unidades_sugeridas" name="unidad_insumo" id="unidad_insumo" class="form-control" value="{{$insumo->unidad_insumo}}" required>
                  <datalist id="unidades_sugeridas">
                      <option value="ML">
                      <option value="M2">
                      <option value="KG">
                      <option value="PZA">
                      <option value="GLB">
                  </datalist>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">CANTIDAD</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="cantidad_insumo" value="{{$insumo->cantidad_insumo}}" class="form-control">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">ZONA DE USO</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="zonadeuso_insumo" value="{{$insumo->zonadeuso_insumo}}" class="form-control">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-4"></div>
                <div class="col-lg-4 col-md-6 text-right">
                  <input type="hidden" name="id_insumo" value="{{$insumo->id_insumo}}" class="form-control">
                  <input type="hidden" name="id_proyecto" value="{{$insumo->id_proyecto}}" class="form-control">
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