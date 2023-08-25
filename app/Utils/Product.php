<?php
namespace App\Utils;

use App\Models\Product as ModelsProduct;

class Product{
    public function getProductByCode($code){
        $product = ModelsProduct::where('products.code','=',$code)->get();
        if ($product->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado.']);
        }

        return response()->json($product);
    }
}