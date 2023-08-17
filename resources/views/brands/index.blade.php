@extends('layouts.app')

@section('extra-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1>Marcas</h1>

    <div class="row mt-5">
        <div class="col-10"></div>
        <div class="col-2 mb-2 text-center">
            <a href="{{route('brand.create')}}" class="btn btn-success">Nueva Marca</a>
        </div>
    </div>
</div>

@endsection

@section('content')
    <div class="container mb-5">
        <table class="table table-striped" id="user-table">
            <thead>
              <tr>
                <th scope="col">Marca</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              
                @foreach ($brands as $brand)
                <tr>
                    <td>{{$brand->name}}</td>
                   
                    <td>
                        <div class="d-flex">
                            <a href="{{route('brand.edit',['id'=>$brand->id])}}" class="btn btn-outline-primary"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Editar"></i></a> 
                            ||
                            <a href="#" class="btn btn-outline-danger" id="userDelete" onclick="deleteBrand({{$brand->id}})" ><i class="fa fa-trash" aria-hidden="true" title="Eliminar"></i></a>
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
    function deleteBrand(id){
        var url = `/brand/${id}/delete`;
        Swal.fire({
                title: 'Confirmar',
                text: '¿Estás seguro de que desea eliminar esta marca?',
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
                                Swal.fire('Marca eliminada', 'La marca ha sido eliminada exitosamente.', 'success');
                                window.location.reload();
                            } else {
                                Swal.fire('Error', 'No se pudo eliminar la marca.', 'error');
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