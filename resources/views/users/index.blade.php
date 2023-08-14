@extends('layouts.app')

@section('extra-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1>Usuarios Registrados</h1>

    <div class="row mt-5">
        <div class="col-10"></div>
        <div class="col-2 mb-2 text-center">
            <a href="{{route('user.create')}}" class="btn btn-success">Nuevo Usuario</a>
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
                <th scope="col">Rol</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->identificacion}}</td>
                    <td>{{$user->name}} {{$user->lastName}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role}}</td>
                    @if($user->status == 1)
                        <td>Activo</td>
                    @else
                        <td>Desactivado</td>
                    @endif
                    <td><a href="#" class="btn btn-outline-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                        || 
                        <a href="#" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        ||
                        @if($user->status == 1)
                            <a href="#" class="btn btn-outline-danger"><i class="fa fa-ban" aria-hidden="true"></i></a>
                        @else
                            <a href="#" class="btn btn-outline-success"><i class="fa fa-check-circle" aria-hidden="true"></i></a>
                        @endif
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
@endsection