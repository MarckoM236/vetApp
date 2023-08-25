@extends('layouts.app')

@section('extra-css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1 >Nueva Venta</h1>
</div>
@endsection

@section('content')
<div class="container mb-5" style="width: 60%;">
    <form method="POST" action="{{route('sale.store')}}">
        @csrf

        <div class="row">
            <div class="col"></div>
            <div class="col d-flex justify-content-end">
                <div class="form-group mb-3  " style="width: 40%;">
                    <label for="invoice" class="form-label">Numero de Factura</label>
        
                    <input id="invoice" type="text" class="form-control @error('invoice') is-invalid @enderror" name="invoice" value="{{ $invoiceNumber }}" readonly autocomplete="invoice">
        
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
                        <input id="customer_cedula" type="number" class="form-control @error('customer_cedula') is-invalid @enderror" name="customer_cedula" value="{{ old('customer_cedula') }}" autocomplete="customer_cedula" autofocus>
                        <input id="customer_id" type="hidden" class="form-control @error('customer_id') is-invalid @enderror" name="customer_id" value="{{ old('customer_id') }}" readonly autocomplete="customer_id" autofocus>
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
                        <input id="customer_name" type="text" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" readonly autocomplete="customer_name" autofocus>
                        @error('customer_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>
                    <div class="form-group mb-3">
                        <label for="customer_email" class="form-label">Email</label>
                        <input id="customer_email" type="text" class="form-control @error('customer_email') is-invalid @enderror" value="{{ old('customer_email') }}" readonly autocomplete="customer_email" autofocus>
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
                        <input id="customer_address" type="text" class="form-control @error('customer_address') is-invalid @enderror" value="{{ old('customer_address') }}" readonly autocomplete="customer_address" autofocus>
                        @error('customer_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>
                    <div class="form-group mb-3">
                        <label for="customer_phone" class="form-label">Telefono</label>
                        <input id="customer_phone" type="text" class="form-control @error('customer_phone') is-invalid @enderror" value="{{ old('customer_phone') }}" readonly autocomplete="customer_phone" autofocus>
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
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="product_code" class="form-label">Codigo</label>
                        <select class="select2 form-select" id="product_code"></select>
                        @error('product_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>
                </div>
                <div class="col"></div>
            </div>

            <div class="row">
                <table class="table" id="table-product">
                    <thead>
                      <tr>
                        <th style="display:none">Id</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Total</th>
                        <th scope="col">Acciones</th>
                      </tr>
                    </thead>
                    <tbody >
                    </tbody>
                  </table>
                  <h5 id="totalSale">Total venta: </h5>
                  <input type="hidden" name="totalSale" id="totalSaleInput">
                  <input class="@error('products') is-invalid @enderror" type="hidden" name="products" id="products" value="{{ old('products') }}">
                    @error('products')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror   
            </div>     
        </div>

        <div class="container border rounded mb-3">
            <h3 class="mt-3">Forma de Pago</h3>
            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="payment_status" class="form-label">Estado de Pago</label>
                        <select class="form-select @error('payment_status') is-invalid @enderror" name="payment_status" id="payment_status">
                            <option value="">Seleccione una opcion</option>
                            <option value="owing" @if(old('payment_status')== 'owing') selected @endif>Debe</option>
                            <option value="paid" @if(old('payment_status')== 'paid') selected @endif>Pagado</option>
                        </select>
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
                        <select class="form-select  @error('payment_method') is-invalid @enderror" name="payment_method" id="payment_method">
                            <option value="">Seleccione una opcion</option>
                            <option value="cash" @if(old('payment_method')== 'cash') selected @endif>Efectivo</option>
                            <option value="card" @if(old('payment_method')== 'card') selected @endif>Tarjeta</option>
                        </select>
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
                        <input id="payment_reference" type="text" class="form-control @error('payment_reference') is-invalid @enderror" name="payment_reference" value="{{ old('payment_reference') }}" autocomplete="payment_reference" autofocus>
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
                <button type="submit" class="btn btn-primary">Guardar Venta</button>
                <a href="#" class="btn btn-danger">Cancelar Venta</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('extra-js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        
        $(document).ready(function() {
            //Consultar Cliente
            getCustomer($('#customer_cedula').val());
            $('#customer_cedula').on('input', function() {
                getCustomer($(this).val());
            });

            //realizar solicitud de porducto por codigo, recibe un array.
          $('.select2').select2({
            placeholder: 'Seleccionar producto',
            minimumInputLength: 3,
            ajax: {
              url: function(params) {
                    return `/product/${params.term}/get`;
                },
                type: 'GET',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return { id: item.id, text: item.name, image: item.photo, price:item.price, code:item.code };
                        })
                    };
                },
                cache: true
            },
            templateResult: formatProduct //uso de la plantilla
          });

          //cuando se seleccione un producto
          $('#product_code').on('change', function() {
            var productSelected = $(this).select2('data')[0];
            if (productSelected) {
                if(!$('#table-product').find(`tr[id="${productSelected.id}"]`).length > 0){
                 addProduct(productSelected);
                }
                else{
                 alert('ya se agrego el producto');
                }
            }
            
            });

            //si existen errores de validacion, y se recarga la pagina se cargan los productos previamente seleccionados
            if($('#products').val() != ''){
                let products = JSON.parse($('#products').val());
                products[0].image;
                for(let i=0;i<products.length;i++){
                    addProduct(products[i],1);
                }
            }

        });

        //Plantilla para mostrar una imagen al lado del nombre del producto
        function formatProduct(product) {
            if (!product.id) {
                return product.text;
            }
            const $container = $('<div class="product-container">');
            $container.append(`<img src="{{asset('storage/${product.image}')}}" alt="${product.id}" class="product-image" style="whidth:50px;height:50px;">`);
            $container.append(`<span class="product-text"> ${product.text} </span>`);
            return $container;
        }

        //Agregar producto a la tabla
        function addProduct(product,up=null){
            var img = null;
            var val = null;
            var total = null;
            if(up==1){
                img = product.image;
                val = product.quantity;
                total= product.totalProduct;
            }
            else{
                img = `{{ asset('storage/${product.image}') }}`;
                val = 1;
                total= product.price;
            }
            
            var newRow = `
                <tr id="${product.id}">
                    <td style="display:none">${product.id}</td>
                    <td><img class="image"  src="${img}" alt="${product.code}" class="product-image" style="width:40px;height:40px;"></td>
                    <td>${product.code}</td>
                    <td>${product.text}</td>
                    <td>${product.price}</td>
                    <td><input type="number" class="quantity" id="quantity-${product.id}" style="width:60px;" value="${val}"></td>
                    <td class="totalProduct" id="${product.id}">${total}</td>
                    <td><button type="button" id="delete-${product.id}">delete</button></td>
                </tr>
                `;
                $('#table-product tbody').append(newRow);
                fullSale();
            
                // Actualizar el precio total en función de la cantidad
                $('#quantity-'+product.id).on('input', function() {
                var quantity = parseInt($(this).val());
                var price = parseFloat(product.price);
                var total = quantity * price;
                $(this).closest('tr').find('#'+product.id).text(total.toFixed(2));
                fullSale();
                });

                // Manejar el clic en el botón de eliminar
                $('#delete-'+product.id).off('click').on('click', function() {
                $(this).closest('tr').remove();
                fullSale();
                });
        }

        //Totalizar la venta
        function fullSale() {
            var total = 0;
            $('#table-product tbody tr').each(function() {
            var totalPriceProduct = parseFloat($(this).find('.totalProduct').text());
            total += totalPriceProduct;
            });
            $('#totalSale').text('Total Venta: $'+total.toFixed(2));
            $('#totalSaleInput').val(total.toFixed(2));
            saveArray();
        }

        //guardar elementos en array
        function saveArray(){
            var dataArrayproduct = [];
            $('#table-product tbody tr').each(function() {
                var rowData = {};
                var cells = $(this).find('td');
                
                rowData.id = $(cells[0]).text();
                rowData.image = $(this).find('.image').attr("src");
                rowData.code = $(cells[2]).text();
                rowData.text = $(cells[3]).text();
                rowData.price = $(cells[4]).text();
                rowData.quantity = $(this).find('.quantity').val();
                rowData.totalProduct = $(cells[6]).text();

                dataArrayproduct.push(rowData);
            });
    
            $('#products').val(JSON.stringify(dataArrayproduct));

        }

        function getCustomer(identificacion){
            if(identificacion.length > 6){
                    $.ajax({
                    url: `/customer/${identificacion}/get`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#alert-div').hide();
                            $('#customer_id').val(response[0].id);
                            $('#customer_name').val(response[0].name + ' ' + response[0].lastName);
                            $('#customer_email').val(response[0].email);
                            $('#customer_address').val(response[0].address);
                            $('#customer_phone').val(response[0].phone);
                        } else {
                            $('#alert-msg').text(response.message);
                            $('#alert-div').show();
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error');
                    }
                });
                }
        }
    </script>
       
@endsection