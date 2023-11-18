<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Sale;
use App\Models\Sale_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count_customers = Customer::select(DB::raw('COUNT(*) AS count_customers'))
        ->first();

        $count_providers = Provider::select(DB::raw('COUNT(*) AS count_providers'))
        ->first();

        $count_products = Product::select(DB::raw('COUNT(*) AS count_products'))
        ->where('status', '=', 1)
        ->where('stock_quantity', '>=', 3)
        ->first();

        $not_stock = Product::select(DB::raw('COUNT(*) AS not_stock'))
        ->where('status', '=', 1)
        ->where('stock_quantity', '<=', 3)
        ->first();

        $chart_product = new stdClass();
        $chart_product->name_product = "";
        $chart_product->quantity_product = "";

        if(Auth::user()->id == 1){
            $total_sale = Sale::select(DB::raw('SUM(total_amount) AS total_sale'))
            ->where('status', '=', 1)
            ->whereBetween('created_at', [now()->subDays(30), now()->addDay()])
            ->first();

            $chart_sale = Sale::select(DB::raw('COUNT(*) AS total'),DB::raw('MONTH(created_at) AS mes'))
            ->where('status', '=', 1)
            ->whereBetween('created_at', [now()->subMonths(6), now()->addDay()])
            ->groupBy('mes')
            ->get();
        }
        else{
            $total_sale = Sale::select(DB::raw('SUM(total_amount) AS total_sale'))
            ->where('status', '=', 1)
            ->where('user_id',Auth::user()->id)
            ->whereBetween('created_at', [now()->subDays(30), now()->addDay()])
            ->first();
            
            $chart_sale = Sale::select(DB::raw('COUNT(*) AS total'),DB::raw('MONTH(created_at) AS mes'))
            ->where('status', '=', 1)
            ->where('user_id',Auth::user()->id)
            ->whereBetween('created_at', [now()->subMonths(6), now()->addDay()])
            ->groupBy('mes')
            ->get();

            $chart_product = Sale_detail::join('products','sale_details.product_id','products.id')
            ->select(DB::raw('products.name AS name_product'),DB::raw('SUM(sale_details.quantity) AS quantity_product'))
            ->groupBy('product_id')
            ->orderBy('quantity_product', 'DESC')
            ->limit(3)
            ->get();
        }

        return view('home', compact('total_sale','count_customers','count_providers','count_products','not_stock','chart_sale','chart_product'));
    }
}
