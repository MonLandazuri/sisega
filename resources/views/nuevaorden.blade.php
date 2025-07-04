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
                    Nueva Orden de Compra
                  </div>
                </div>
              </div>
            </div>
          </div>

          <form method="POST" action="{{ route('listado.nuevaoc')}}" class="wizard-content mt-2">
                @csrf
            <div class="wizard-pane"> 
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">Contratista</label>
                <div class="col-lg-4 col-md-6">
                  <select class="form-control" name="contratista_oc">
                    <option value="0">Selecciona un contratista</option>
                    @foreach ($contratistas as $contratista)
                      <option value="{{ $contratista->id_contratista}}">
                          {{ $contratista->nombre_contratista }} 
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">Fecha OC</label>
                <div class="col-lg-4 col-md-6">
                  <input type="date" class="form-control" name="fecha_oc">
                </div>
              </div>
              <div class="form-group row align-items-center text-right">
                <div class="col-lg-8 col-md-6">
                  <input type="hidden" class="form-control" name="id_proyecto" value="{{ $id_proyecto }}">
                  <button type="submit" class="btn btn-icon icon-right btn-dark">Siguiente <i class="fa fa-angle-right"></i></button>
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


