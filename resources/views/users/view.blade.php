@extends('layouts.app')

@section('extra-css')
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1 >Informacion del Usuario</h1>
</div>
@endsection

@section('content')
<div class="container mb-5" style="width: 60%;">
    <form method="POST">

        <div class="container text-center" >
            <img @if(!empty($user->photo)) src="{{asset('storage/'.$user->photo)}}" @else src="" @endif  alt="" style="width: 200px; height:200px; border-radius:25px;" id="preview_img" class="mt-2">
        </div>

        <div class="form-group mb-3">
            <label for="identificacion" class="form-label">Identificacion</label>

            <input id="identificacion" type="text" class="form-control @error('identificacion') is-invalid @enderror" name="identificacion" value="{{ $user->identificacion }}"  autocomplete="identificacion" readonly >

        </div>

        <div class="form-group mb-3">
            <label for="name" class="form-label ">Nombre</label>

            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" readonly>

        </div>

        <div class="form-group mb-3">
            <label for="lastName" class="form-label ">Apellido</label>

            <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ $user->lastName }}"  autocomplete="lastName" readonly>

        </div>

        <div class="form-group mb-3">
            <label for="email" class="form-label ">{{ __('Email Address') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}"  autocomplete="email" readonly>
            
        </div>

        <div class="form-group mb-3">
            <label for="role" class="form-label">Rol</label>
            <input class="form-control" type="text" @if($user->role_id == 1) value="Administrador" @else value="Vendedor" @endif readonly>
            
        </div>

        <div class="text-center form-group mt-3 mb-3">
            <div class="col-md-6 offset-md-4">
                <a href="{{route('user.index')}}" class="btn btn-danger">Regresar</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('extra-js')
@endsection