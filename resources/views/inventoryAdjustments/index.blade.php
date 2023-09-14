@extends('layouts.app')

@section('extra-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1>Ajustes De Invetario</h1>

    <div class="row mt-5">
        <div class="col-10 d-flex justify-content-between align-items-center">
        </div>
        <div class="col-2 mb-2 text-center">
            <a href="{{route('adjustment.create')}}" class="btn btn-success">Nuevo Ajuste</a>
        </div>
    </div>
</div>
@endsection

@section('content')
@include('products.modal')
    <div class="container mb-5">
        <table class="table table-striped" id="ajustment-table">
            <thead>
              <tr>
                <th scope="col">Producto</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Tipo de Ajuste</th>
                <th scope="col">Motivo de Ajuste</th>
                <th scope="col">Usuario</th>
                <th scope="col">Fecha</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @if($adjustments->isEmpty())
              <tr class="text-center">
                <td colspan="7">No hay Ajustes Registrados</td>
              </tr>  
              @else
              
                @foreach ($adjustments as $adjustment)
                <?php //dd($adjustment->product_name); ?>
                    <tr>
                        <td>{{$adjustment->product_code}} - {{$adjustment->product_name}}</td>
                        <td>{{$adjustment->quantity}}</td>
                        <td>@if($adjustment->type == "entry")Entrada @else Salida @endif</td>
                        <td>{{$adjustment->reason}}</td>
                        <td>{{$adjustment->user_name}}</td>
                        <td>{{$adjustment->created_at}}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{route('adjustment.show',['id'=>$adjustment->id])}}" class="btn btn-outline-success"  title="Ver"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr> 
                @endforeach  
              @endif  
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

@endsection