<?php

namespace App\Http\Controllers;

use App\Models\Payment_detail;
use App\Models\Sale;
use App\Models\Sale_detail;
use App\Utils\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    private $model;
    private $sale_details;
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
        //
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
        $request->validate([
            'customer_cedula'=>['nullable','numeric','min:7'],
            'products'=>['required'],
            'payment_status'=>['required'],
            'payment_method'=>['required']
        ]);

        $invoiceExist = $this->model::where('sales.invoice','=',$request->invoice)->exists();
        if($invoiceExist){
            return redirect()->route('sale.create')->with('error', 'Factura ya existe');
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
                $sale_details->unit_price = $product->totalProduct;
                $sale_details->save();
            }

            $payment_details = $this->payment_details;
            $payment_details->sales_id = $saleId;
            $payment_details->payment_status = $request->payment_status;
            $payment_details->payment_method = $request->payment_method;

            if(!empty($request->payment_reference)){
                $payment_details->payment_reference = $request->payment_reference;
            }
            $payment_details->save();

            return redirect()->route('sale.create')->with('success', 'Se registro la venta exitosamente');
        }
        else{
            return redirect()->route('sale.create')->with('error', 'Hubo un error al registrar la venta.');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
