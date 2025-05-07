<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">SISEGA</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown active">
              <a href="{{ route('inicio') }}" class="nav-link"><i class="fas fa-fire"></i><span>General</span></a>
            </li>
            <li class="menu-header">Proyectos</li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Proyectos</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('proyectos') }}">Listado</a></li>
                <li><a class="nav-link" href="layout-transparent.html">Dependencias</a></li>
                <li><a class="nav-link" href="layout-transparent.html">OC</a></li>
              </ul>
            </li>
            
            <li class="menu-header">Usuarios</li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Usuarios</span></a>
              <ul class="dropdown-menu">
                <li><a href="{{ route('usuarios') }}">Usuarios</a></li> 
                <li><a href="auth-register.html">Registrar Usuario</a></li> 
                <li><a href="auth-reset-password.html">Reset Password</a></li> 
              </ul>
            </li>
          </ul>

          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="" class="btn btn-primary btn-lg btn-block btn-icon-split">
              <i class="fas fa-window-close"></i> Cerrar Sesión
            </a>
          </div>        
        </aside>
      </div>