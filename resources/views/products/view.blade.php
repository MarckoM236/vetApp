
@extends('layouts.app')

@section('extra-css')
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1 >Detalles del  Producto</h1>
</div>
@endsection

@section('content')
<div class="container mb-5" style="width: 60%;">
    <form method="POST">
    
        <div class="container text-center" >
            <img @if(!empty($product->photo)) src="{{asset('storage/'.$product->photo)}}" @else src="" @endif  alt="" style="width: 200px; height:200px; border-radius:25px;" id="preview_img" class="mt-2">
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <div class="form-group mb-3">
                    <label for="code" class="form-label">Codigo</label>
                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ $product->code }}" autocomplete="code" readonly>
                </div>
            </div>
            <div class="col">
                <div class="form-group mb-3">
                    <label for="name" class="form-label ">Nombre</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $product->name }}" autocomplete="name" readonly>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="form-group mb-3">
                    <label for="price" class="form-label ">Precio de venta</label>
                    <input id="price" type="text" class="form-control " name="price" value="${{ $product->price }}" autocomplete="price" readonly>
                </div>
            </div>
            <div class="col">
                <div class="form-group mb-3">
                    <label for="stock" class="form-label ">Stock actual</label>
                    <input id="stock" type="text" class="form-control " name="stock" value="{{ $product->stock_quantity }}" autocomplete="stock" readonly>
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="description" class="form-label ">Descripcion</label>

            <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $product->description }}" autocomplete="description" readonly>

        </div>

        <div class="row">
            <div class="col">
                <div class="form-group mb-3">
                    <label for="category" class="form-label ">Categoria</label>
                    <input type="text" class="form-control" value="{{$product->category_name}}" readonly>
                </div>
            </div>
            <div class="col">
                <div class="form-group mb-3">
                    <label for="brand" class="form-label ">Marca</label>
                    <input type="text" class="form-control" value="{{$product->brand_name}}" readonly>
                </div>
            </div>
        </div>

        <div class="text-center form-group mt-3 mb-3">
            <div class="col-md-6 offset-md-4">
                <a href="{{route('product.index')}}" class="btn btn-danger">Regresar</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('extra-js')
@endsection