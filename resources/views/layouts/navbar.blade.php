<nav class="navbar navbar-expand-lg main-navbar">
<!--<ul class="navbar-nav mr-6">
    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
<form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
    </ul>
    <div class="search-element">
    <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
    <div class="search-backdrop"></div>
    <div class="search-result">
        <div class="search-header">
        Histories
        </div>
        <div class="search-item">
        <a href="#">How to hack NASA using CSS</a>
        <a href="#" class="search-close"><i class="fas fa-times"></i></a>
        </div>
        <div class="search-item">
        <a href="#">Kodinger.com</a>
        <a href="#" class="search-close"><i class="fas fa-times"></i></a>
        </div>
        <div class="search-item">
        <a href="#">#Stisla</a>
        <a href="#" class="search-close"><i class="fas fa-times"></i></a>
        </div>
        <div class="search-header">
        Result
        </div>
        <div class="search-item">
        <a href="#">
            <img class="mr-3 rounded" width="30" src="assets/img/products/product-3-50.png" alt="product">
            oPhone S9 Limited Edition
        </a>
        </div>
        <div class="search-item">
        <a href="#">
            <img class="mr-3 rounded" width="30" src="assets/img/products/product-2-50.png" alt="product">
            Drone X2 New Gen-7
        </a>
        </div>
        <div class="search-item">
        <a href="#">
            <img class="mr-3 rounded" width="30" src="assets/img/products/product-1-50.png" alt="product">
            Headphone Blitz
        </a>
        </div>
        <div class="search-header">
        Projects
        </div>
        <div class="search-item">
        <a href="#">
            <div class="search-icon bg-danger text-white mr-3">
            <i class="fas fa-code"></i>
            </div>
            Stisla Admin Template
        </a>
        </div>
        <div class="search-item">
        <a href="#">
            <div class="search-icon bg-primary text-white mr-3">
            <i class="fas fa-laptop"></i>
            </div>
            Create a new Homepage Design
        </a>
        </div>
    </div>
    </div>
</form>-->
<ul class="navbar-nav navbar-right">
    <!--<li class="dropdown dropdown-list-toggle">
        <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep">
            <i class="far fa-envelope"></i>
        </a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Mensajes
        </div>
        <div class="dropdown-list-content dropdown-list-message">
        <a href="#" class="dropdown-item dropdown-item-unread">
            <div class="dropdown-item-avatar">
            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle">
            <div class="is-online"></div>
            </div>
            <div class="dropdown-item-desc">
            <b>Nuevo</b>
            <p>Hola! nuevo mensaje</p>
            <div class="time">hace 10 horas</div>
            </div>
        </a>
        </div>
        <div class="dropdown-footer text-center">
        <a href="#">ver todo <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
    </li>
    <li class="dropdown dropdown-list-toggle">
        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep">
            <i class="far fa-bell"></i>
        </a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Notificaciones
        </div>
        <div class="dropdown-list-content dropdown-list-icons">
        <a href="#" class="dropdown-item dropdown-item-unread">
            <div class="dropdown-item-icon bg-primary text-white">
            <i class="fas fa-code"></i>
            </div>
            <div class="dropdown-item-desc">
            Nueva notificación
            <div class="time text-primary">hace 2 minutos</div>
            </div>
        </a>
        </div>
        <div class="dropdown-footer text-center">
        <a href="#">Ver todo <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
    </li>-->
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
    <div class="d-sm-none d-lg-inline-block">@auth
    <p>Bienvenido, {{ Auth::user()->name }}!</p>
@else
    <p>Por favor, inicia sesión.</p>
@endauth</div></a>
    <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-title">Iniciaste sesión</div>
        <a href="{{ route('usuarios') }}" class="dropdown-item has-icon">
        <i class="far fa-user"></i> Perfil
        </a>
        <a href="{{ route('usuarios') }}" class="dropdown-item has-icon">
        <i class="fas fa-bolt"></i> Actividades
        </a>
        <a href="{{ route('usuarios') }}" class="dropdown-item has-icon">
        <i class="fas fa-cog"></i> Configuración
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{route('logout')}}" class="dropdown-item has-icon text-danger">
        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
    </div>
    </li>
</ul>
</nav>