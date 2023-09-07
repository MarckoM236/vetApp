<?php
namespace App\Utils;

use App\Models\Product as ModelsProduct;

class Product{
    public function getProductByCode($code){
        $product = ModelsProduct::where('products.code','=',$code)->get();
        if ($product->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado.']);
        }
        
        foreach ($product as $item) {
            if($item->stock_quantity == 0){
                return response()->json(['success' => false, 'message' => 'No hay existencias en stock.']);
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