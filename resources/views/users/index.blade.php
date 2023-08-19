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
                    <td>
                        <div class="d-flex">
                            <a href="{{route('user.view',['id'=>$user->id])}}" class="btn btn-outline-success"  ><i class="fa fa-eye" aria-hidden="true" title="Ver"></i></a>
                            ||
                            <a href="{{route('user.edit',['id'=>$user->id])}}" class="btn btn-outline-primary"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Editar"></i></a> 
                            ||
                            <a href="#" class="btn btn-outline-danger" id="userDelete" onclick="deleteUser({{$user->id}})" ><i class="fa fa-trash" aria-hidden="true" title="Eliminar"></i></a>
                            ||
                            @if($user->status == 1)
                            <form action="{{route('user.status',['id'=>$user->id])}}" method="POST" >
                            @csrf
                            @method('PUT')
                                <input type="hidden" name="status" value="0">
                                <button type="submit" class="btn btn-outline-danger"><i class="fa fa-ban" aria-hidden="true" title="Deshabilitar"></i></button>
                            </form>
                            @else
                            <form action="{{route('user.status',['id'=>$user->id])}}" method="POST" >
                            @csrf
                            @method('PUT')
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="btn btn-outline-success"><i class="fa fa-check-circle" aria-hidden="true" title="Habilitar"></i></button>
                            </form>
                                
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
<script>
    function deleteUser(id){
        var url = `/user/${id}/delete`;
        Swal.fire({
                title: 'Confirmar',
                text: '¿Estás seguro de que desea eliminar el usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Usuario eliminado', 'El usuario ha sido eliminado exitosamente.', 'success');
                                window.location.reload();
                            } else {
                                Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error');
                        }
                    });
                }
            });
    }
</script>
@endsection