@extends('layouts.app')

@section('extra-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1>Ventas Realizadas</h1>

    <div class="row mt-5">
        <div class="col-10 d-flex justify-content-between align-items-center">
        </div>
        <div class="col-2 mb-2 text-center">
            <a href="{{route('sale.create')}}" class="btn btn-success">Registrar Venta</a>
        </div>
    </div>
</div>
@endsection

@section('content')
@include('products.modal')
    <div class="container mb-5">
        <table class="table table-striped" id="product-table">
            <thead>
              <tr>
                <th scope="col">Factura</th>
                <th scope="col">Valor</th>
                <th scope="col">Cliente</th>
                <th scope="col">Vendedor</th>
                <th scope="col">Fecha</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              
                @foreach ($sales as $sale)
                <tr>
                    <td>{{$sale->invoice}}</td>
                    <td>${{$sale->total}}</td>
                    <td>{{$sale->customerName}}</td>
                    <td>{{$sale->sellerName}}</td>
                    <td>{{$sale->created}}</td>
                    <td>@if($sale->status == 1)Aceptada @else Anulada @endif</td>
                   
                    <td>
                        <div class="d-flex">
                            <a href="{{route('sale.view',['id'=>$sale->id])}}" class="btn btn-outline-success"  title="Ver"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            
                            @if (auth()->user()->role_id == 1 && $sale->status == 1 )
                                ||
                                <a href="#" class="btn btn-outline-danger" id="saleNull" onclick="saleCancel({{$sale->id}})" title="Anular Venta"><i class="fa fa-ban" aria-hidden="true"></i></a>
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

<script>
    function saleCancel(id){
        var url = `/sale/${id}/cancel`;
        Swal.fire({
                title: 'Confirmar',
                text: '¿Estás seguro de que desea Anular la Venta?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, anular',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Venta Anulada', response.message, 'success');
                                window.location.reload();
                            } else {
                                Swal.fire('Error', response.message, 'error');
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
