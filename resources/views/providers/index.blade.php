@extends('layouts.app')

@section('extra-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1>Proveedores Registrados</h1>

    <div class="row mt-5">
        <div class="col-10 d-flex justify-content-between align-items-center">
        </div>
        <div class="col-2 mb-2 text-center">
            <a href="{{route('provider.create')}}" class="btn btn-success">Nuevo Proveedor</a>
        </div>
    </div>
</div>
@endsection

@section('content')
    <div class="container mb-5">
        <table class="table table-striped" id="product-table">
            <thead>
              <tr>
                <th scope="col">Nit</th>
                <th scope="col">Nombre</th>
                <th scope="col">Contacto</th>
                <th scope="col">Email</th>
                <th scope="col">Telefono</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              
                @foreach ($providers as $provider)
                <tr>
                    <td>{{$provider->nit}}</td>
                    <td>{{$provider->name}}</td>
                    <td>{{$provider->contact_name}}</td>
                    <td>{{$provider->email}}</td>
                    <td>{{$provider->phone}}</td>
                   
                    <td>
                        <div class="d-flex">
                            <a href="{{route('provider.view',['id'=>$provider->id])}}" class="btn btn-outline-success"  ><i class="fa fa-eye" aria-hidden="true" title="Ver"></i></a>
                            
                            @if (auth()->user()->role_id == 1)
                                ||
                                <a href="{{route('provider.edit',['id'=>$provider->id])}}" class="btn btn-outline-primary"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Editar"></i></a> 
                                ||
                                <a href="#" class="btn btn-outline-danger" id="providerDelete" onclick="deleteObject({{$provider->id}},'provider','Proveedor eliminado exitosamente.','No se pudo eliminar el proveedor')" ><i class="fa fa-trash" aria-hidden="true" title="Eliminar"></i></a>
                            @endif
                        </div>
                    </td>
                </tr> 
                @endforeach  
            </tbody>
          </table>
    </div>
@endsection

@section('extra-js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    new DataTable('#product-table');
</script>
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
<script src="{{ asset('js/functions.js') }}"></script>

@endsection
