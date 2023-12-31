<?php

namespace App\Http\Controllers;

use App\Models\Inventory_adjustment;
use App\Models\Product as ModelsProduct;
use App\Utils\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryAdjustmentController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Inventory_adjustment();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adjustments = $this->model::join('users','inventory_adjustments.user_id','=','users.id')
        ->join('products','inventory_adjustments.product_id','=','products.id')
        ->select('inventory_adjustments.id as id','inventory_adjustments.quantity as quantity','inventory_adjustments.type as type',
        'inventory_adjustments.reason as reason','products.name as product_name','products.code as product_code','users.name as user_name','inventory_adjustments.created_at as created_at')
        ->get();

        return view('inventoryAdjustments.index',['adjustments'=>$adjustments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventoryAdjustments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $messages = ['productId.required'=>'Debe indicar a que producto realizara el ajuste'];
            $request->validate([
                'type'=>['required'],
                'quantity'=>['required','numeric'],
                'reason'=>['required'],
                'productId'=>['required']
            ],$messages);

            $adjustment = $this->model;
            $adjustment->user_id = Auth::user()->id;
            $adjustment->product_id = $request->productId;
            $adjustment->type = $request->type;
            $adjustment->quantity = $request->quantity;
            $adjustment->reason = $request->reason;

            $adjustment->save();

            Product::updateStock($adjustment->product_id,$adjustment->quantity,$adjustment->type);

            return redirect()->route('adjustment.index')->with('success', 'Se realizo el Ajuste de stock exitosamente');

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
        $adjustments = $this->model::join('users','inventory_adjustments.user_id','=','users.id')
        ->join('products','inventory_adjustments.product_id','=','products.id')
        ->where('inventory_adjustments.id',$id)
        ->select('inventory_adjustments.quantity as quantity','inventory_adjustments.type as type','inventory_adjustments.created_at as created_at',
        'inventory_adjustments.reason as reason','products.name as product_name','products.code as product_code','products.stock_quantity as product_stock',
        'products.photo as product_img','users.name as user_name')
        ->get();

        return view('inventoryAdjustments.view',['adjustments'=>$adjustments]);
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
