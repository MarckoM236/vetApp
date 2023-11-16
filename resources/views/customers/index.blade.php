@extends('layouts.app')

@section('extra-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1>Clientes Registrados</h1>

    <div class="row mt-5">
        <div class="col-10"></div>
        <div class="col-2 mb-2 text-center">
            <a href="{{route('customer.create')}}" class="btn btn-success">Nuevo Cliente</a>
        </div>
    </div>
</div>

@endsection

@section('content')
    <div class="container mb-5">
        <table class="table table-striped" id="user-table">
            <thead>
              <tr>
                <th scope="col">Identificacion</th>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Email</th>
                <th scope="col">Telefono</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              
                @foreach ($customers as $customer)
                <tr>
                    <td>{{$customer->identificacion}}</td>
                    <td>{{$customer->name}} {{$customer->lastName}}</td>
                    <td>{{$customer->email}}</td>
                    <td>{{$customer->phone}}</td>
                   
                    <td>
                        <div class="d-flex">
                            <a href="{{route('customer.view',['id'=>$customer->id])}}" class="btn btn-outline-success"  ><i class="fa fa-eye" aria-hidden="true" title="Ver"></i></a>
                            ||
                            <a href="{{route('customer.edit',['id'=>$customer->id])}}" class="btn btn-outline-primary"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Editar"></i></a> 
                            ||
                            <a href="#" class="btn btn-outline-danger" id="customerDelete" onclick="deleteObject({{$customer->id}},'customer','El cliente ha sido eliminado exitosamente.','No se pudo eliminar el cliente.')" ><i class="fa fa-trash" aria-hidden="true" title="Eliminar"></i></a>
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
    new DataTable('#user-table');
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
<script src="{{ mix('js/functions.js') }}"></script>
@endsection