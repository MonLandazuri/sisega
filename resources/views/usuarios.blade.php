@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Usuarios</h1>
    </div>
    @foreach ($usuarios as $usuario)
    <div class="row">    
      <div class="col-12 col-sm-12 col-lg-7">
        <div class="card author-box card-primary">
          <div class="card-body">
            <div class="author-box-left">
              <img alt="image" src="{{asset('dashboard/assets/img/avatar/avatar-1.png')}}" class="rounded-circle author-box-picture">
              <div class="clearfix"></div>
              <a href="#" class="btn btn-primary mt-3 follow-btn" data-follow-action="alert('¿Desactivar este usuario?');" data-unfollow-action="alert('unfollow clicked');">{{$usuario->status}}</a>
            </div>
            <div class="author-box-details">
              <div class="author-box-name">
                <a href="#">{{$usuario->name}}</a>
              </div>
              <div class="author-box-job">{{$usuario->role}}</div>
              <div class="author-box-description">
                <p></p>
              </div>
              <div class="mb-2 mt-3"><div class="text-small font-weight-bold">{{$usuario->email}}</div></div>
              <div class="w-100 d-sm-none"></div>
              <div class="float-right mt-sm-0 mt-3">
                <a href="#" class="btn"><i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>         
    </div>
    @endforeach
</section>
@endsection()