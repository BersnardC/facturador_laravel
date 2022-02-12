@extends('layouts.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-4" style="margin: auto;">
            <form action="{{url('register')}}" method="POST" class="text-center mt-5" onsubmit="handle_register(event)">
                <h1>Registrar</h1>
                @if(Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{Session::get('error')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @csrf
                <input type="text" name="username" id="name" class="form-control mb-2" placeholder="Nombre de Usuario" />
                <input type="text" name="email" id="email" class="form-control mb-2" placeholder="Email" />
                <input type="password" name="password" id="password" class="form-control mb-2" placeholder="Password" />
                <div class="d-grid gap-2 mb-2">
                    <button type="submit" class="btn btn-dark" id="bn-save"><i class="bi bi-box-arrow-in-up-right"></i> Regístrame</button>
                </div>
                <a href="{{url('login')}}"><i class="bi bi-box-arrow-in-right"></i> Iniciar sesión</a>
            </form>
        </div>
    </div>
</div>
@endsection()