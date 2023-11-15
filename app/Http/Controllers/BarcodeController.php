<?php

namespace App\Http\Controllers;

use App\Utils\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;

class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.barcode');
    }

    public function store(Request $request)
    {
        try {
            $barcode = new DNS1D();
            $code = $request->input('code');
            $result = Product::getProducts($code);

            return view('products.barcode', ['result' => $result,'barcode'=>$barcode]);

        } catch (\Exception $e) {
            return view('products.barcode', ['success' => false, 'message' => 'No se pudo procesar la solicitud!']);
        }
    }

    public function pdf(Request $request){
        $barcode = new DNS1D();
        $products = json_decode($request->barcode);
        $pdf = Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif'])->loadView('products.barcodePdf', ['result'=>$products,'barcode'=>$barcode]);
        return $pdf->download('products.pdf');

    }
}
