@extends('layouts.app')

@section('extra-css')
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1 >Actualizar Informacion de Usuarios</h1>
</div>
@endsection

@section('content')
<div class="container mb-5" style="width: 60%;">
    <form method="POST" action="{{route('user.update',['id'=>$user->id])}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="identificacion" class="form-label">Identificacion</label>

            <input id="identificacion" type="text" class="form-control @error('identificacion') is-invalid @enderror" name="identificacion" value="{{ $user->identificacion }}" required autocomplete="identificacion" autofocus >

            @error('identificacion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            
        </div>

        <div class="form-group mb-3">
            <label for="name" class="form-label ">Nombre</label>

            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            
        </div>

        <div class="form-group mb-3">
            <label for="lastName" class="form-label ">Apellido</label>

            <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ $user->lastName }}" required autocomplete="lastName" autofocus>

            @error('lastName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            
        </div>

        <div class="form-group mb-3">
            <label for="email" class="form-label ">{{ __('Email Address') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="switch" name="switch" @error('password') checked @enderror>
            <label class="form-check-label" for="switch">Modificar Contraseña</label>
        </div>

        <div id="pass" style="display: none">
            <div class="form-group mb-3">
                <label for="password" class="form-label ">{{ __('Password') }}</label>
    
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
    
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
            </div>
    
            <div class="form-group mb-3">
                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
    
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="photo" class="form-label">Foto</label>
            <input id="photo" type="file" class="form-control" name="photo"  autocomplete="photo">
        </div>
        <div class="d-flex justify-content-center">
            <img @if(!empty($user->photo)) src="{{asset('storage/'.$user->photo)}}" @else src="" @endif  alt="" style="display: none; width: 100px; height:100px;" id="preview_img" class="mt-2">
        </div>

        <div class="form-group mb-3">
            <label for="role" class="form-label">Rol</label>

            <select class="form-select" name="role" id="role">
                <option @if($user->role_id == 1) selected @endif value="1">Administrador</option>
                <option @if($user->role_id == 2) selected @endif value="2">Vendedor</option>
            </select>
            
        </div>

        <div class="text-center form-group mt-3 mb-3">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{route('user.index')}}" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('extra-js')
@if(session('success'))
        <script>    
            Swal.fire(
            'Exito!',
            '{{ session('success') }}',
            'success'
            )
        </script>
@endif
@if(session('error'))
    <script>    
        Swal.fire(
        'Algo ha salido mal!',
        '{{ session('error') }}',
        'error'
        )
    </script>
@endif
<script>
    $(document).ready(function() {
        if ($('#switch').is(':checked')) {
                $('#pass').show();
            }
        $('#switch').change(function() {
            if ($(this).is(':checked')) {
                $('#pass').show();
            } else {
                $('#pass').hide();
            }
        });
    });
</script>

<!-- preview image -->
<script>
    $(document).ready(async function() {
        let photo = $('#photo');
        let preview = $('#preview_img');
        let preview_actually = preview.attr('src');
        preview.show();

        photo.change(function(){
            let file = this.files[0];
            if (file == null) {
                if (preview_actually) {
                    preview.attr('src', preview_actually); 
                } else {
                    preview.hide();
                    preview.attr('src', '');
                }
                
            }else{
                preview.show();
                preview.attr('src', URL.createObjectURL(file));
            }
        });
    });
</script>

@endsection