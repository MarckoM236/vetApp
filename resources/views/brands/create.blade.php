@extends('layouts.app')

@section('extra-css')
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1 >Nuevas Marcas</h1>
</div>
@endsection

@section('content')
<div class="container mb-5" style="width: 60%;">
    <form method="POST" action="{{ route('brand.store') }} ">
        @csrf

        <div class="form-group mb-3">
            <label for="brand" class="form-label">Nombre de la Marca</label>

            <input id="brand" type="text" class="form-control @error('brand') is-invalid @enderror" name="brand" value="{{ old('brand') }}" required autocomplete="brand" autofocus>

            @error('brand')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            
        </div>

        <div class="text-center form-group mt-3 mb-3">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{route('brand.index')}}" class="btn btn-danger">Cancelar</a>
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