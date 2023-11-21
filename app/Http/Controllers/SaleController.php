<?php

namespace App\Http\Controllers;

use App\Models\Payment_detail;
use App\Models\Sale;
use App\Models\Sale_detail;
use App\Utils\Invoice;
use App\Utils\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    private $model;
    private $payment_details;

    public function __construct()
    {
        $this->model = new Sale();
        $this->payment_details = new Payment_detail();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = $this->model::leftjoin('users','sales.user_id','=','users.id')
        ->leftjoin('customers','sales.customer_id','=','customers.id')
        ->select('sales.id as id','sales.invoice as invoice','sales.total_amount as total','sales.created_at as created',
        'sales.status as status','users.name as sellerName','customers.name as customerName')
        ->get();
        return view('sales.index',['sales'=>$sales]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoiceNumber = Invoice::generateInvoiceNumber();
        return view('sales.create',compact('invoiceNumber'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'customer_cedula'=>['nullable','numeric','min:7'],
                'products'=>['required'],
                'payment_status'=>['required'],
                'payment_method'=>['required']
            ]);

            $invoiceExist = $this->model::where('sales.invoice','=',$request->invoice)->exists();
            if($invoiceExist){
                return redirect()->route('sale.index')->with('error', 'Factura ya existe');
            }

            $sale = $this->model;
            $sale->invoice = $request->invoice;
            $sale->user_id = Auth::user()->id;
            $sale->total_amount = $request->totalSale;

            if(!empty($request->customer_id)){
                $sale->customer_id = $request->customer_id;
            }

            $sale->save();

            $saleId = $sale->id;
            
            if(!empty($saleId)){
                $products = json_decode($request->products);
                foreach($products as $product){
                    $sale_details = new Sale_detail();
                    $sale_details->sale_id =  $saleId;
                    $sale_details->product_id = $product->id;
                    $sale_details->quantity = $product->quantity;
                    $sale_details->unit_price = $product->price;
                    $sale_details->total_price = $product->totalProduct;
                    $sale_details->save();
                    Product::updateStock($product->id,$product->quantity,'output');
                }

                $payment_details = $this->payment_details;
                $payment_details->sales_id = $saleId;
                $payment_details->payment_status = $request->payment_status;
                $payment_details->payment_method = $request->payment_method;

                if(!empty($request->payment_reference)){
                    $payment_details->payment_reference = $request->payment_reference;
                }
                $payment_details->save();

                return redirect()->route('sale.index')->with(['success'=>'Se registro la venta exitosamente','id_sale'=>$saleId]);
            }
            else{
                return redirect()->route('sale.index')->with('error', 'Hubo un error al registrar la venta.');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales = $this->model::leftjoin('users','sales.user_id','=','users.id')
        ->leftjoin('customers','sales.customer_id','=','customers.id')
        ->leftjoin('sale_details','sales.id','=','sale_details.sale_id')
        ->leftjoin('products','sale_details.product_id','=','products.id')
        ->leftjoin('payment_details','sales.id','=','payment_details.sales_id')
        ->where('sales.id',$id)
        ->select('sales.invoice as invoice','sales.total_amount as total','sales.created_at as created',
        'sales.status as status','users.name as sellerName','customers.name as customerName','customers.lastName as customerLastName','customers.identificacion as identificacion',
        'customers.email as customerEmail','customers.address as customerAddress','customers.phone as customerPhone',
        'products.name as name','products.code as code','products.photo as photo','sale_details.quantity as quantity_product','sale_details.unit_price as priceProduct',
        'sale_details.total_price  as total_product','payment_details.payment_status as payment_status','payment_details.payment_method as payment_method',
        'payment_details.payment_reference as payment_reference')
        ->get();

        return view('sales.view',['sales'=>$sales]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //N/A
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //N/A
    }

    public function cancelSale($id){
        try{
            $sale = $this->model::find($id);
            if (!$sale) {
                return response()->json(['success' => false, 'message' => 'Factura no encontrada.']);
            }
            
            if($sale->status == 1){
                $sale->status = 0;
                $sale->save();

                $products = $this->model::join('sale_details','sales.id','=','sale_details.sale_id')
                ->where('sales.id','=',$id)
                ->select('sale_details.product_id as product_id','sale_details.quantity')
                ->get();

                if($products->count() > 0){
                    foreach($products as $product){
                        Product::updateStock($product->product_id,$product->quantity,'entry');
                    }
                    return response()->json(['success' => true, 'message' => 'Venta anulada exitosamente.']);   
            }   
            }
            else{
                return response()->json(['success' => false, 'message' => 'La factura ya se encuentra anulada.']);
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } 
    }
}
