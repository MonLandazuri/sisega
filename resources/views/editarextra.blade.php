@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1>Editar Elemento Extraordinario</h1>
          </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Editar Extraordinario</h4>
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
                    Extraordinario
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
          <form method="POST" action="{{ route('guardar.editarextra')}}" class="wizard-content mt-2">
                @csrf
            <div class="wizard-pane">
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">NO</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="no_extra" class="form-control" value="{{$extra->no_extra}}">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">CONCEPTO</label>
                <div class="col-lg-4 col-md-6">
                  <textarea class="form-control" name="concepto_extra">{{$extra->concepto_extra}}</textarea>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">UNIDAD</label>
                <div class="col-lg-4 col-md-6">
                  <select class="form-control" name="unidad_extra">
                    <option value="0">Selecciona una Unidad</option>
                      @if($extra->unidad_extra=="KG")
                        <option value="KG" selected>KG</option>
                      @else
                        <option value="KG">KG</option>
                      @endif
                      @if($extra->unidad_extra=="M2")
                        <option value="M2" selected>M2</option>
                      @else
                        <option value="M2">M2</option>
                      @endif
                      @if($extra->unidad_extra=="M3")
                        <option value="M3" selected>M3</option>
                      @else
                        <option value="M3">M3</option>
                      @endif
                      @if($extra->unidad_extra=="ML")
                        <option value="ML" selected>ML</option>
                      @else
                        <option value="ML">ML</option>
                      @endif
                      @if($extra->unidad_extra=="PZA")
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
                  <input type="text" name="cantidad_extra" value="{{$extra->cantidad_extra}}" class="form-control">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">P.U.</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="pu_extra" value="{{$extra->pu_extra}}" class="form-control">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">P.U. CONTRATISTA</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="pu_contratista_extra" value="{{$extra->pu_contratista_extra}}" class="form-control">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-4"></div>
                <div class="col-lg-4 col-md-6 text-right">
                  <input type="hidden" name="id_extra" value="{{$extra->id_extra}}" class="form-control">
                  <input type="hidden" name="id_proyecto" value="{{$extra->id_proyecto}}" class="form-control">
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