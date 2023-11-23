@extends('layouts.app')

@section('extra-css')
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1 >Nuevo Ajuste de inventario</h1>
</div>
@endsection

@section('content')
<div class="container mb-5" style="width: 60%;">
    <!-- consult product by code -->
    <div class="container mb-4">
        <div class="row g-3 justify-content-center align-items-center mb-5">
            <div class="col-auto">
                <label for="code" class="col-form-label"><strong>Codigo Producto</strong></label>
            </div>
            <div class="col-auto">
                <input id="code" type="number" class="form-control" name="code" autocomplete="code" autofocus>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary" id="consultProduct">Consultar</button>
            </div>
            <div class="text-center">
                <span class="text-danger" role="alert">
                    <strong id="error"></strong>
                </span>
            </div>
        </div>
    </div>
    <!-- end consult product by code -->

    <!-- Adjustment -->
    <div id="adjustment" style="display: none;">
        <!-- info product -->
        <div class="border rounded p-3">
            <div class="row g-3 mb-2">
                <div class="col text-center">
                    <img id="productImg" src="" alt="producto" style="right: 100px;height:100px;">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="form-group">
                        <label for="productCode" class="form-label">Codigo Producto</label>
                        <input id="productCode" type="text" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="form-group">
                        <label for="productName" class="form-label">Nombre Producto</label>
                        <input id="productName" type="text" class="form-control" readonly>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="productStock" class="form-label">Stock Actual</label>
                        <input id="productStock" type="text" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
        <!-- end info product-->

        <!-- form adjustment -->
        <div class="m-3 text-center">
            <h4>Actualizar Stock</h4>
        </div>
        <form method="POST" action="{{ route('adjustment.store') }}">
            @csrf
            <div class="row g-3 mb-2">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="type" class="form-label">Tipo de Actualizacion</label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" required>
                            <option value="" @if(old('type') == "") selected @endif>Seleccione un tipo</option>
                            <option value="entry" @if(old('type') == "entry") selected @endif>Entrada</option>
                            <option value="output" @if(old('type') == "output") selected @endif>Salida</option>
                        </select>
                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror        
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="quantity" class="form-label ">Cantidad</label>
                        <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" required autocomplete="quantity">
                        @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror   
                    </div>
                </div>
            </div>
            <div class="row g-3 mb-2">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="reason" class="form-label ">Motivo</label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" name="reason" id="reason" cols="30" rows="4" required>{{ old('reason') }}</textarea>
                        @error('reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror     
                    </div>
                    <input id="productId" type="hidden" name="productId" class="form-control @error('productId') is-invalid @enderror" readonly>
                    @error('productId')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror   
                </div>
            </div>
    
            <div class="text-center form-group mt-3 mb-3">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{route('adjustment.index')}}" class="btn btn-danger">Cancelar</a>
                </div>
            </div>
        </form>
        <!-- end form adjustment -->
    </div>
     <!-- Adjustment -->
</div>
@endsection

@section('extra-js')
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

    <!-- make a request to the product utility, it sends a parameter that indicates that it is a setting as true -->
    <script>
        $(document).ready(function() {
            var code = null;
            $("#consultProduct").click(function() {
                code = $('#code').val();
                $.ajax({
                        url: `/product/${code}/get`,
                        type: 'GET', 
                        data: {
                            adjustment: true
                        },
                        success: function(response) {
                            if(response.success == false){
                                $("#error").text(response.message);
                                $('#productImg').attr("src", "#");
                                $('#productCode').val("");
                                $('#productId').val("");
                                $('#productName').val("");
                                $('#productStock').val("");
                                $('#adjustment').hide();
                            }
                            else{
                                $('#adjustment').show();
                                if(response[0].photo != null){
                                    $('#productImg').attr("src", "{{ asset('storage/') }}" + '/' + response[0].photo);
                                }
                                else{
                                    $('#productImg').attr("src", "{{ asset('img/product.png') }}");
                                }
                                
                                $('#productCode').val(response[0].code);
                                $('#productId').val(response[0].id);
                                $('#productName').val(response[0].name);
                                $('#productStock').val(response[0].stock_quantity);

                                $('#code').val("");
                                $("#error").text("");

                            }
   
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error en la solicitud:', textStatus, errorThrown);
                        }
                });
            });
        });
    </script>

@endsection