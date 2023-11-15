@extends('layouts.app')

@section('extra-css')
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1>Generar Codigos de Barra</h1>
</div>
@endsection

@section('content')
<div class="container">
    <!-- consult product by code -->
    <div class="container mb-4">
      <form action="{{route('barcode.get')}}" method="POST">
        <div class="row g-3 justify-content-center align-items-center mb-5">
            
                @csrf
                <div class="col-auto">
                    <label for="code" class="col-form-label"><strong>Codigo Producto</strong></label>
                </div>
                <div class="col-auto">
                    <input id="code" type="number" class="form-control" name="code" autocomplete="code" autofocus>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success" id="consultProduct">Generar</button>
                </div>
            
            <div class="text-center">
                <span class="text-danger" role="alert">
                    <strong id="error"></strong>
                </span>
            </div>

        </div>
      </form>    
    </div>
    <!-- end consult product by code -->
@if(isset($result))
    @php 
      $jsonResult = $result->getData();
      //print_r($jsonResult);
    @endphp
    @if(isset($jsonResult->success))
      <div class="alert alert-danger" role="alert">
        {{$jsonResult->message}}
      </div>
    
    @else
      <div class="row text-center mb-3">
        <div class="col">
          <form action="{{route('barcode.pdf')}}" method="POST">
            @csrf
            <input type="hidden" name="barcode" value="{{json_encode($jsonResult->products)}}">
            <input class="btn btn-success" type="submit" value="Generar PDF">
          </form>
        </div>
        <div class="col">
          <a href="{{route('product.index')}}" class="btn btn-danger">Regresar</a>
        </div>
      </div>
       <!-- show barcode -->
    <table class="table" id="barcode">
      <thead>
      </thead>
      <tbody>
        @for ($j=0; $j < count($jsonResult->products); $j += 3)
          <tr>
            @for ($i = $j; $i < ($j+3); $i++)
              @if($i >= count($jsonResult->products) )
                @break
              @endif
              <td>
                <div class="card text-center p-3" style="width: 18rem;">
                  <img class="card-img-top" src="data:image/png;base64,{{$barcode->getBarcodePNG($jsonResult->products[$i]->code, 'C128A')}}" alt="barcode" style="right: 150px; height:100px;">
                  <p class="mt-1"><strong>{{$jsonResult->products[$i]->code}}</strong></p>
                  <div class="card-body">
                    <p class="card-text">{{$jsonResult->products[$i]->name}}</p>
                  </div>
                </div>
              </td>
            @endfor
          </tr>
       @endfor    
      </tbody>
    </table>
  <!--end show Barcode -->
    @endif
@endif
</div>
@endsection

@section('extra-js')
@endsection