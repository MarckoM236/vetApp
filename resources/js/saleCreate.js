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
            if (data.success == false) {
                return { results: [{text: data.message}] };
            }
            else{
                return {
                results: data.map(function(item) {
                    return { id: item.id, text: item.name, image: item.photo, price:item.price, code:item.code };
                })
            };
            }      
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
    $container.append(`<img src="/storage/${product.image}" alt="${product.id}" class="product-image" style="whidth:50px;height:50px;">`);
    $container.append(`<span class="product-text"> ${product.text} </span>`);
    return $container;
}

//Agregar producto a la tabla
function addProduct(product,up=null){
    if (product.id) {
        var img = null;
        var val = null;
        var total = null;
        if(up==1){
            img = product.image;
            val = product.quantity;
            total= product.totalProduct;
        }
        else{
            img = `/storage/${product.image}`;
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

//obtener cliente por identificacion
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