<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/bootstrap-social/bootstrap-social.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('dashboard/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/assets/css/components.css')}}">
<!-- Start GA -->
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="{{asset('img/logosisega.png')}}" alt="logo" width="200" class="shadow-light">
            </div>

            <div class="card card-dark">
              <div class="card-header"><h4>Iniciar Sesión</h4></div>

              <div class="card-body">
                <form method="POST" action="{{ route('login.submit')}}" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus value="{{ old('email')}}">
                    <div class="invalid-feedback">
                      Por favor introduce tu correo electrónico
                    </div>
                  </div>
                  @if ($errors->has('email'))
                    <code>{{ $errors->first('email')}}<code>
                  @endif

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Contraseña</label>
                      <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                          Olvidaste tu contraseña?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      Por favor introduce tu contraseña
                    </div>

                    @if ($errors->has('password'))
                      <code>{{ $errors->first('password')}}<code>
                    @endif
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Recordarme</label>
                    </div>
                  </div>

                  <div class="form-group">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-lg btn-block" tabindex="4">
                      Entrar
                    </button>
                  </div>
                </form>
                

              </div>
            </div>
            
            <div class="simple-footer">
              Copyright &copy; SISEGA 2025
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{asset('dashboard/assets/modules/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/popper.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/tooltip.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/moment.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/stisla.js')}}"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="{{asset('dashboard/assets/js/scripts.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/custom.js')}}"></script>
</body>
</html>