@extends('layouts.app')

@section('extra-css')
@endsection

@section('head')
<div class="container text-center pt-5">
    <h1 >Dashboard</h1>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center">
        @if(Auth::user()->role_id == 1)
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">$20.000</h5>
                  <p class="card-text">Compras ultimos 30 días</p>
                </div>
                <div class="card-footer text-center">
                    <a class="icon-link icon-link-hover" style="color:white; text-decoration:none;" href="#">
                        Compras
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-3">
            <div class="card text-bg-success mb-3" style="max-width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">$ {{number_format($total_sale->total_sale, 0, ',', '.');}}</h5>
                  <p class="card-text">Ventas ultimos 30 días</p>
                </div>
                <div class="card-footer text-center">
                    <a class="icon-link icon-link-hover" style="color:white; text-decoration:none;" href="{{route('sale.index')}}">
                        Ventas
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">{{$count_customers->count_customers}}</h5>
                  <p class="card-text">Clientes</p>
                </div>
                <div class="card-footer text-center">
                    <a class="icon-link icon-link-hover" style="color:white; text-decoration:none;" href="{{route('customer.index')}}">
                        Clientes
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">{{$count_providers->count_providers}}</h5>
                  <p class="card-text">Proveedores</p>
                </div>
                <div class="card-footer text-center">
                    <a class="icon-link icon-link-hover" style="color:white; text-decoration:none;" href="{{route('provider.index')}}">
                        Proveedores
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center align-items-center">
        <div class="col-md-3">
            <div class="card text-bg-primary mb-3" style="max-width: 36rem;">
                <div class="card-body">
                  <h5 class="card-title">{{$count_products->count_products}}</h5>
                  <p class="card-text">Productos disponibles</p>
                </div>
                <div class="card-footer text-center">
                    <a class="icon-link icon-link-hover" style="color:white; text-decoration:none;" href="{{route('product.index',['stock'=>1])}}">
                        Productos
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3" style="max-width: 36rem;">
                <div class="card-body">
                  <h5 class="card-title">{{$not_stock->not_stock}}</h5>
                  <p class="card-text">Productos sin stock</p>
                </div>
                <div class="card-footer text-center">
                    <a class="icon-link icon-link-hover" style="color:white; text-decoration:none;" href="{{route('product.index',['stock'=>0])}}">
                        Productos
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center align-items-center mt-5 mb-5">
        <div class="col-md-6">
            <canvas id="chart_sales"></canvas>
        </div>
        @if(Auth::user()->role_id == 1)
        <div class="col-md-6">
            <canvas id="chart_purchases"></canvas>
        </div>
        @else
        <div class="col-md-6" style="max-width: 400px !important;">
            <canvas id="chart_products" ></canvas>
        </div>
        @endif
    </div>

</div>
@endsection

@section('extra-js')
<script>
    const months = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];

    const chart_sales = document.getElementById('chart_sales');
    let sales = @json($chart_sale);//data php
    let x_sale = [];
    let y_sale = [];
    for(i=0;i<sales.length;i++){
        y_sale.push(sales[i].total);
        x_sale.push(months[sales[i].mes - 1]);
    }

    new Chart(chart_sales, {
    type: "line",
    data: {
        labels: x_sale,
        datasets: [{
        label:'Ventas',
        data: y_sale,
        borderColor: "blue",
        fill: false
        }]
    },
    options: {
        legend: {display: false},
        plugins: {
            title: {
                display: true,
                text: 'Ventas ultimos 6 meses',
                font: {
                    size: 16
                }
            }
        },
    }
    });
</script>

@if(Auth::user()->role_id == 1)
<script>
    const chart_purchases = document.getElementById('chart_purchases');
    let purchases = @json($chart_sale);//data php
    let x_purchase = [];
    let y_purchase = [];
    for(i=0;i<purchases.length;i++){
        y_purchase.push(purchases[i].total);
        x_purchase.push(months[purchases[i].mes - 1]);
    }

    new Chart(chart_purchases, {
    type: "line",
    data: {
        labels: x_purchase,
        datasets: [{
        label:'Compras',
        data: y_purchase,
        borderColor: "red",
        fill: false
        }]
    },
    options: {
        legend: {display: false},
        plugins: {
            title: {
                display: true,
                text: 'Compras ultimos 6 meses',
                font: {
                    size: 16
                }
            }
        },
    }
    });
</script>
@else
<script>
    const chart_products = document.getElementById('chart_products');
    const barColors = [
            "rgba(74,176,7)",
            "rgba(0,0,255,0.8)",
            "rgba(234,18,61)",
        ];

    let products = @json($chart_product);//data php
    let x_products = [];
    let y_products = [];
    for(i=0;i<products.length;i++){
        y_products.push(products[i].quantity_product);
        x_products.push(products[i].name_product);
    }

    new Chart(chart_products, {
    type: "doughnut",
    data: {
        labels: x_products,
        datasets: [{
            label:'Vendidos',
            data: y_products,
            backgroundColor: barColors,
            }]
    },
    options: {
        legend: {display: false},
        plugins: {
            title: {
                display: true,
                text: 'Productos mas vendidos',
                font: {
                    size: 16
                }
            }
        },
    }
    });
</script>
@endif
@endsection
