@extends('layouts.master')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="section">
          <div class="section-header">
            <h1>Nuevo Contratista</h1>
          </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Agregar Nuevo Contratista</h4>
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
                    Contratista
                  </div>
                </div>
              </div>
            </div>
          </div>

          <form method="POST" action="{{ route('guardar.nuevocontratista')}}" class="wizard-content mt-2">
                @csrf
            <div class="wizard-pane">
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">Nombre del Contratista</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="nombre_contratista" class="form-control" placeholder="Max. 100 Caracteres" maxlength="100">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">Dirección de Contratista</label>
                <div class="col-lg-4 col-md-6">
                  <textarea class="form-control" name="direccion_contratista" rows="3" maxlength="255" placeholder="Max. 255 Caracteres"></textarea>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">Banco del Contratista</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="banco_contratista" class="form-control" placeholder="Ejem. BBVA">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">No. Tarjeta del Contratista</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="tarjeta_contratista" class="form-control"
                  maxlength="16"
                  pattern="[0-9]{16}"
                  inputmode="numeric"
                  placeholder="Max. 16 dígitos">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">CLABE del Contratista</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="clabe_contratista" class="form-control"
                  maxlength="18"
                  pattern="[0-9]{18}"
                  inputmode="numeric"
                  placeholder="Max. 18 dígitos">
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-4 text-md-right text-left">Cuenta del Contratista</label>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="cuenta_contratista" class="form-control"
                  maxlength="12"
                  pattern="[0-9]{12}"
                  inputmode="numeric"
                  placeholder="Max. 12 dígitos">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-4"></div>
                <div class="col-lg-4 col-md-6 text-right">
                  <input type="submit" class="btn btn-icon icon-right btn-primary" value="Guardar">
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