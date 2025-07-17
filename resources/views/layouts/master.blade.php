<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>General Dashboard &mdash; SISEGA</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/jqvmap/dist/jqvmap.min.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/weather-icon/css/weather-icons.min.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/weather-icon/css/weather-icons-wind.min.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/summernote/summernote-bs4.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/datatables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/assets/modules/dropzonejs/dropzone.css')}}">


  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('dashboard/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/assets/css/components.css')}}">

  <style>
    .table:not(.table-sm):not(.table-md):not(.dataTable) td,.table:not(.table-sm):not(.table-md):not(.dataTable) th{
      padding: 0 5px !important;
      height: 35px !important;
      vertical-align: middle;
    }
  </style>
<!-- Start GA -->

<!-- /END GA -->
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <!-- Barra navegacion -->
      @include('layouts.navbar')

      <!-- Barra Lateral -->
     @include('layouts.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2025 <div class="bullet"></div> Desarrollado por <a href="https://mrmarketing.mx/">MR Marketing</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
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
  <script src="{{asset('dashboard/assets/modules/simple-weather/jquery.simpleWeather.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/chart.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/jqvmap/dist/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/summernote/summernote-bs4.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/datatables/datatables.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/modules/dropzonejs/min/dropzone.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/page/components-multiple-upload.js')}}"></script>


  <!-- Page Specific JS File -->
  <script src="{{asset('dashboard/assets/js/page/index-0.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/page/modules-datatables.js')}}"></script>
  
  <!-- Template JS File -->
  <script src="{{asset('dashboard/assets/js/scripts.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/custom.js')}}"></script>   
  @yield('scripts')
</body>
</html>