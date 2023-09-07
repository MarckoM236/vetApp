@extends('layouts.app')

@section('extra-css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1 >Detalle de Venta <span  class="@if($sales[0]->status == 0)text-danger @else text-success @endif">(@if($sales[0]->status == 0) Anulada @else Aprobada @endif)</span></h1>
</div>
@endsection

@section('content')
<div class="container mb-5" style="width: 60%;">
    <form method="POST" >

        <div class="row">
            <div class="col"></div>
            <div class="col d-flex justify-content-end">
                <div class="form-group mb-3  " style="width: 40%;">
                    <label for="invoice" class="form-label">Numero de Factura</label>
        
                    <input id="invoice" type="text" class="form-control @error('invoice') is-invalid @enderror" name="invoice" value="{{$sales[0]->invoice}}" readonly autocomplete="invoice">
        
                    @error('invoice')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                </div>
            </div>
        </div>

        <div class="container border rounded mb-3">
            <h3 class="mt-3">Informacion del Cliente</h3>
            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="customer_cedula" class="form-label">Cedula</label>
                        <input id="customer_cedula" type="text" class="form-control @error('customer_cedula') is-invalid @enderror" name="customer_cedula" @if(!empty($sales[0]->identificacion)) value="{{$sales[0]->identificacion}}" @else value="N/A" @endif autocomplete="customer_cedula" readonly autofocus>
                        @error('customer_cedula')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                        <span class="invalid-feedback" role="alert" style="display: none" id="alert-div">
                            <strong id="alert-msg"></strong>
                        </span>   
                    </div>
                </div>
                <div class="col"></div>
            </div>
    
            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="customer_name" class="form-label">Nombre Completo</label>
                        <input id="customer_name" type="text" class="form-control @error('customer_name') is-invalid @enderror" @if(!empty($sales->customerName)) value="{{$sales->customerName.' '.$sales->customerLastName}}" @else value="N/A" @endif readonly autocomplete="customer_name" autofocus>
                        @error('customer_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>
                    <div class="form-group mb-3">
                        <label for="customer_email" class="form-label">Email</label>
                        <input id="customer_email" type="text" class="form-control @error('customer_email') is-invalid @enderror" @if(!empty($sales[0]->customerEmail)) value="{{$sales[0]->customerEmail}}" @else value="N/A" @endif readonly autocomplete="customer_email" autofocus>
                        @error('customer_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="customer_address" class="form-label">Direccion</label>
                        <input id="customer_address" type="text" class="form-control @error('customer_address') is-invalid @enderror" @if(!empty($sales[0]->customerAddress)) value="{{$sales[0]->customerAddress}}" @else value="N/A" @endif readonly autocomplete="customer_address" autofocus>
                        @error('customer_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>
                    <div class="form-group mb-3">
                        <label for="customer_phone" class="form-label">Telefono</label>
                        <input id="customer_phone" type="text" class="form-control @error('customer_phone') is-invalid @enderror" @if(!empty($sales[0]->customerPhone)) value="{{$sales[0]->customerPhone}}" @else value="N/A" @endif readonly autocomplete="customer_phone" autofocus>
                        @error('customer_phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>
                </div>
            </div>
        </div>

        <div class="container border  rounded mb-3" >
            <h3 class="mt-3">Productos</h3>

            <div class="row">
                <table class="table text-center" id="table-product">
                    <thead>
                      <tr>
                        <th scope="col">Imagen</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td><img src="{{asset('storage/'.$sale->photo)}}" alt="product" style="width:60px;height:60px;"></td>
                            <td>{{$sale->code}}</td>
                            <td>{{$sale->name}}</td>
                            <td>{{$sale->priceProduct}}</td>
                            <td>{{$sale->quantity_product}}</td>
                            <td>{{$sale->total_product}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <h5 id="totalSale">Total venta: {{$sales[0]->total}} </h5>
            </div>     
        </div>

        <div class="container border rounded mb-3">
            <h3 class="mt-3">Forma de Pago</h3>
            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="payment_status" class="form-label">Estado de Pago</label>
                        <input class="form-control" type="text" value="{{$sales[0]->payment_status}}" readonly>
                        @error('payment_status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="payment_method" class="form-label">Medio de Pago</label>
                        <input class="form-control" type="text" value="{{$sales[0]->payment_method}}" readonly>
                        @error('payment_method')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror     
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="payment_reference" class="form-label">Referencia de Pago</label>
                        <input id="payment_reference" type="text" class="form-control @error('payment_reference') is-invalid @enderror" name="payment_reference" @if(!empty($sales[0]->payment_reference)) value="{{$sales[0]->payment_reference}}" @else value="N/A" @endif readonly autocomplete="payment_reference" autofocus>
                        @error('payment_reference')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center form-group mt-3 mb-3">
            <div class="col-md-6 offset-md-4">
                <a href="{{route('sale.index')}}" class="btn btn-danger">Regresar</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('extra-js')

       
@endsection