<?php
namespace App\Utils;

use App\Models\Product as ModelsProduct;
use Illuminate\Http\Request;

class Product{
    //obtain products by code, it is used for both sales and stock adjustments, the latter sends parameter as true
    public function getProductByCode(Request $request,$code){
        $product = ModelsProduct::where('products.code','=',$code)->get();
        if ($product->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado.']);
        }

        foreach ($product as $item) {
            if($item->stock_quantity == 0 && $item->status == 0){
                return response()->json(['success' => false, 'message' => 'Producto no inicializado']);
            }
            elseif($item->stock_quantity == 0 && $item->status == 1){
                if($request->adjustment == true ){
                    return response()->json($product);
                }
                else{
                    return response()->json(['success' => false, 'message' => 'No hay existencias en stock.']);
                }
            }      
        }
        return response()->json($product);
    }

    public static function updateStock($id,$quantity,$type){
        if(empty($quantity)){
               $quantity = 0; 
        }
        $product = ModelsProduct::find($id);
        if ($product) {
            if($type == 'output'){
                $newStock = $product->stock_quantity - $quantity;
            }
            if($type == 'entry'){
                $newStock = $product->stock_quantity + $quantity;
            }
            $product->stock_quantity = $newStock;
            $product->save();
        }
    }
}