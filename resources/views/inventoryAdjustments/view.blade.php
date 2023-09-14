@extends('layouts.app')

@section('extra-css')
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1 >Detalle de Ajuste de inventario</h1>
</div>
@endsection

@section('content')
<div class="container mb-5" style="width: 60%;">

    <!-- Adjustment -->
    <div id="adjustment" >
        <!-- info product -->
        <div class="border rounded p-3">
            <div class="row g-3 mb-2">
                <div class="col text-center">
                    <img id="productImg" @if(empty($adjustments[0]->product_img)) src="{{asset('img/product.png')}}" @else src="{{asset('storage/'.$adjustments[0]->product_img)}}" @endif alt="producto" style="right: 100px;height:100px;">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="form-group">
                        <label for="productCode" class="form-label">Codigo Producto</label>
                        <input id="productCode" type="text" class="form-control" value="{{$adjustments[0]->product_code}}" readonly>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="form-group">
                        <label for="productName" class="form-label">Nombre Producto</label>
                        <input id="productName" type="text" class="form-control" value="{{$adjustments[0]->product_name}}" readonly>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="productStock" class="form-label">Stock Actual</label>
                        <input id="productStock" type="text" class="form-control" value="{{$adjustments[0]->product_stock}}" readonly>
                    </div>
                </div>
            </div>
        </div>
        <!-- end info product-->

        <!-- form adjustment -->
        <div class="m-3 text-center">
            <h4>Actualizacion de Stock</h4>
        </div>
        <form method="POST">
            <div class="row g-3 mb-2">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="reason" class="form-label ">Usuario que Realizo el Ajuste</label>
                        <input type="text" class="form-control" name="reason" value="{{$adjustments[0]->user_name}}" id="reason" readonly>
                    </div>  
                </div>
            </div>
            <div class="row g-3 mb-2">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="type" class="form-label">Tipo de Actualizacion</label>
                        <input class="form-control" type="text" @if($adjustments[0]->type == "entry") value="Entrada" @else value="Salida" @endif readonly>    
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="quantity" class="form-label ">Cantidad</label>
                        <input id="quantity" type="number" class="form-control " name="quantity" value="{{$adjustments[0]->quantity}}" required autocomplete="quantity">  
                    </div>
                </div>
            </div>
            <div class="row g-3 mb-2">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="reason" class="form-label ">Motivo</label>
                        <textarea class="form-control" name="reason" id="reason" cols="30" rows="4" required>{{$adjustments[0]->reason}}</textarea>
                    </div>  
                </div>
            </div>
    
            <div class="text-center form-group mt-3 mb-3">
                <div class="col-md-6 offset-md-4">
                    <a href="{{route('adjustment.index')}}" class="btn btn-danger">Regresar</a>
                </div>
            </div>
        </form>
        <!-- end form adjustment -->
    </div>
     <!-- Adjustment -->
</div>
@endsection

@section('extra-js')
@endsection