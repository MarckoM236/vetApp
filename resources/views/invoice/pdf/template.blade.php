<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        @page {
            margin: 0in;
        }
        .container {
            text-align: justify;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
        }
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #0072FA;
            color: white;
        }
        footer {
            padding: 20px;
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #0072FA;
            color: white;
        }
        img{
            width: 150px;
            height: 150px;
        }
        .bold {
            font-weight: bold;
        }
        .top-margin {
            margin-top: 25px;
        }
        .bottom-margin {
            margin-bottom: 25px;
        }
        .text {
            font-size: 30px;
            color: #0072FA;
            padding: 20px;
            text-align: right;
            margin-right: 30px;
        }
        .center{
            text-align: center;
        }
        .wd{
            width: 110px;
            text-align: left;
        }
        
    </style>
</head>

<body>
    <div class="container">
        <header>
            <table>
                <tr>
                    <td>
                        <img src="{{ public_path('img/logo.png') }}" alt="Logo">
                    </td>
                    <td>
                        <h1>FACTURA DE VENTA</h1>
                    </td>
                </tr>
                <tr class="top-margin">
                    <td>
                        <table class="bottom-margin">
                            <tr>
                                <td class="bold wd">
                                    <ul>
                                        <li>Cliente</li>
                                        <li>E-mail</li>
                                        <li>Dirección</li>
                                        <li>Teléfono</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li>{{$invoice[0]->name_customer}} {{$invoice[0]->lastName_customer}}</li>
                                        <li>{{$invoice[0]->email_customer}}</li>
                                        <li>{{$invoice[0]->address_customer}}</li>
                                        <li>{{$invoice[0]->phone_customer}}</li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <td class="bold wd">
                                    <ul>
                                        <li>Factura No</li>
                                        <li>Fecha</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li>{{$invoice[0]->invoice_sale}}</li>
                                        <li>{{\Carbon\Carbon::parse($invoice[0]->date_sale)->format('d/m/Y')}}</li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </header>
        <main>
            <table class="top-margin">
                <thead class="center">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Valor unitario</th>
                        <th>Valor total</th>
                    </tr>
                </thead>
                <tbody class="center">
                    @foreach ($invoice as $product)
                        <tr>
                            <td>{{$product->code_product}}</td>
                            <td>{{$product->name_product}}</td>
                            <td>{{$product->quantity_product}}</td>
                            <td>{{number_format($product->unit_price_product,0,',','.');}}</td>
                            <td>{{number_format($product->total_price_product,0,',','.');}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="center">
                    <tr></tr>
                    <tr>
                        <td colspan="3"></td>
                        <td class="bold">
                            <ul>
                                <li>Subtotal</li>
                                <li>Iva</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>{{number_format($invoice[0]->subTotal_sale,0,',','.');}}</li>
                                <li>{{number_format($invoice[0]->iva_sale,0,',','.');}}</li>
                            </ul>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <table class="top-margin">
                <tr>
                    <td></td>
                    <td>
                        <div class="text">
                               Total a Pagar ${{number_format($invoice[0]->subTotal_sale + $invoice[0]->iva_sale,0,',','.');}}
                        </div>
                    </td>
                </tr>
            </table>
        </main>

        <footer>
            <table>
                <tr>
                    <td>
                        <h3>Contacto</h3>
                        <ul>
                            <li>(55) 1234 - 5678</li>
                            <li>www.sitioincreible.com</li>
                            <li>hola@sitioincreible.com</li>
                            <li>Calle Cualquiera 123, Cualquier Lugar</li>
                        </ul>
                    </td>
                    <td>
                        <h3>Información de pago</h3>
                        <table>
                            <tr>
                                <td class="bold wd">
                                    <ul>
                                        <li>Estado</li>
                                        <li>Medio de Pago</li>
                                        <li>Fecha de pago</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @if($invoice[0]->status_payment == 'paid')
                                            <li>Pagado</li>
                                        @else
                                            <li>Debe</li>
                                        @endif
                                        @if($invoice[0]->method_payment == 'cash')
                                            <li>Efectivo</li>
                                        @else
                                            <li>Tarjeta</li>
                                        @endif
                                        @if($invoice[0]->status_payment == 'owing')
                                            <li>Pendiente de Pago</li>
                                        @else
                                            <li>{{\Carbon\Carbon::parse($invoice[0]->date_payment)->format('d/m/Y')}}</li>
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </footer>
    </div>
</body>
</html>
