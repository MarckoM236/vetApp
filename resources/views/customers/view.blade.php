@extends('layouts.app')

@section('extra-css')
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1 >Detalle del Cliente</h1>
</div>
@endsection

@section('content')
<div class="container mb-5" style="width: 60%;">
    <form>
        @csrf

        <div class="form-group mb-3">
            <label for="identificacion" class="form-label">Identificacion</label>

            <input id="identificacion" type="text" class="form-control @error('identificacion') is-invalid @enderror" name="identificacion" value="{{ $customer->identificacion }}"  autocomplete="identificacion" autofocus readonly>
            
        </div>

        <div class="form-group mb-3">
            <label for="name" class="form-label ">Nombre</label>

            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $customer->name }}" autocomplete="name" autofocus readonly>

        </div>

        <div class="form-group mb-3">
            <label for="lastName" class="form-label ">Apellido</label>

            <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ $customer->lastName }}" autocomplete="lastName" autofocus readonly>

        </div>

        <div class="form-group mb-3">
            <label for="email" class="form-label ">{{ __('Email Address') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$customer->email}}" autocomplete="email" readonly>

        </div>

        <div class="form-group mb-3">
            <label for="address" class="form-label ">Direccion</label>

            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{$customer->address}}" autocomplete="address" readonly>

        </div>

        <div class="form-group mb-3">
            <label for="phone" class="form-label ">Telefono</label>

            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{$customer->phone}}"  autocomplete="phone" readonly>

        </div>

        <div class="form-group mb-3">
            <label for="city" class="form-label ">Ciudad</label>

            <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{$customer->city}}" autocomplete="city" readonly>
 
        </div>

        <div class="form-group mb-3">
            <label for="neighborhood" class="form-label ">Barrio</label>

            <input id="neighborhood" type="text" class="form-control @error('neighborhood') is-invalid @enderror" name="neighborhood" value="{{$customer->neighborhood}}" autocomplete="neighborhood" readonly>

        </div>

        <div class="text-center form-group mt-3 mb-3">
            <div class="col-md-6 offset-md-4">
                <a href="{{route('customer.index')}}" class="btn btn-danger">Regresar</a>
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
@endsection