<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html"><img src="{{asset('img/logosisega.png')}}" width="150px"/></a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">S</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li><a class="nav-link" href="{{ route('inicio') }}" ><i class="fas fa-building"></i><span>General</span></a></li>
            <li class="menu-header">Proyectos</li>
            {{-- Opción visible SOLO para administradores --}}
            @auth
                @if (Auth::user()->isAdmin())
            <li><a class="nav-link" href="{{ route('nuevo.proyecto') }}"><i class="fas fa-file"></i><span>Nuevo</span></a></li>
                @endif
            @endauth
            <li><a class="nav-link" href="{{ route('proyectos') }}"><i class="fas fa-list"></i><span>Listado</span></a></li>
            <li><a class="nav-link" href="{{ route('contratistas') }}"><i class="fas fa-address-book"></i><span>Contratistas</span></a></li>
            </li>
            
            <li class="menu-header">Usuarios</li>
            <li><a href="{{ route('usuarios') }}"><i class="fas fa-user"></i><span>Usuarios</span></a></li> 
            <li><a href="{{ route('usuarios') }}"><i class="fas fa-user-plus"></i><span>Registrar Usuario</span></a></li> 
            <li><a href="{{ route('usuarios.editar.password') }}"><i class="fas fa-user-lock"></i><span>Cambiar Contraseña</span></a></li> 
          </ul>

          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{route('logout')}}" class="btn btn-dark btn-lg btn-block btn-icon-split">
              <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
          </div>        
        </aside>
      </div>