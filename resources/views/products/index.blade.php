@extends('layouts.app')

@section('extra-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1>Productos Registrados</h1>

    <div class="row mt-5">
        <div class="col-10 d-flex justify-content-between align-items-center">
            <a href="" class="btn btn-success">Codigos de Barras</a>
        </div>
        <div class="col-2 mb-2 text-center">
            <a href="{{route('product.create')}}" class="btn btn-success">Nuevo Producto</a>
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
                <th scope="col">Producto</th>
                <th scope="col">Codigo</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Stock</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              
                @foreach ($products as $product)
                <tr>
                    <td><img @if($product->photo !="") src="{{asset('storage/'.$product->photo)}}" @else src="" @endif alt="{{$product->code}}" style="width:80px;height:80px;"></td>
                    <td>{{$product->code}}</td>
                    <td>{{$product->name}}</td>
                    <td>${{$product->price}}</td>
                    <td>{{$product->stock_quantity}}</td>
                   
                    <td>
                        <div class="d-flex">
                            <a href="{{route('product.view',['id'=>$product->id])}}" class="btn btn-outline-success"  ><i class="fa fa-eye" aria-hidden="true" title="Ver"></i></a>
                            
                            @if (auth()->user()->role_id == 1)
                                ||
                                <a href="{{route('product.edit',['id'=>$product->id])}}" class="btn btn-outline-primary"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Editar"></i></a> 
                                ||
                                <a href="#" class="btn btn-outline-danger" id="productDelete" onclick="deleteObject({{$product->id}},'product','Producto eliminado exitosamente.','No se pudo eliminar el producto')" ><i class="fa fa-trash" aria-hidden="true" title="Eliminar"></i></a>
                                @if($product->status == 0)
                                    ||
                                    <a href="#" class="btn btn-outline-warning" onclick="modalStock({{$product->id}})"><i class="fa fa-play" aria-hidden="true" title="Iniciar stock"></i></a> 
                                @endif
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
<script>
    function modalStock(id){
        $('#id_product').val(id); 
        $('#stockModal').modal('show');       
    }   
</script>

@endsection
