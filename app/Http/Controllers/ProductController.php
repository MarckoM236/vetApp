<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    private $model;
    private $categories;
    private $brands;

    public function __construct()
    {
        $this->model= new Product();
        $this->categories = new Category();
        $this->brands = new Brand();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($stock = null)
    {
        $products = $this->model::join('categories','products.category_id','=','categories.id')
        ->join('brands','products.brand_id','=','brands.id')
        ->select('products.*','categories.name as name_category','brands.name as name_brand');
        if($stock <> null && $stock==1){
            $products->where('status',1)
            ->where('stock_quantity','>=',3);
        }
        if($stock <> null && $stock==0){
            $products->where('status',1)
            ->where('stock_quantity','<=',3);
        }
        $products = $products->get();
        return view('products.index',['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categories::select('id','name')->get();
        $brands = $this->brands::select('id','name')->get();
        return view('products.create',compact('categories','brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        try{

            $productExist = $this->model::where('products.code',$request->code)
            ->exists();
            if($productExist){
                return redirect()->route('product.create')->with('error', 'El producto ya existe');
            }
            else{
                $product = $this->model;
                $product->code = $request->code;
                $product->name = $request->name;
                $product->description = $request->description;
                $product->category_id = $request->category;
                $product->brand_id = $request->brand;
                
                if ($request->hasFile('photo')) {

                    $archivo = $request->file('photo');
                    $nombre = $archivo->getClientOriginalName();
                    $renombrado = time() . '_' . $nombre;
                    $ruta = $archivo->storeAs('prducts', $renombrado, 'public');
                    
                    $product->photo = $ruta;
                }
                $product->save();

                return redirect()->route('product.index')->with('success', 'Producto creado exitosamente');
            }

        } catch (ValidationException $e) {
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
        $product = $this->model::join('categories','products.category_id','=','categories.id')
        ->join('brands','products.brand_id','=','brands.id')
        ->where('products.id',$id)
        ->select('products.*','categories.name as category_name','brands.name as brand_name')
        ->first();

        if(!$product){
            return redirect()->route('product.index')->with('error', 'Producto no encontrado');
        }

        return view('products.view',['product'=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->categories::select('id','name')->get();
        $brands = $this->brands::select('id','name')->get();
        $product = $this->model::join('categories','products.category_id','=','categories.id')
        ->join('brands','products.brand_id','=','brands.id')
        ->where('products.id',$id)
        ->select('products.*','categories.name as category_name','brands.name as brand_name')
        ->first();

        if(!$product){
            return redirect()->route('product.index')->with('error', 'Producto no encontrado');
        }

        return view('products.edit',compact('product','categories','brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        try{

            $product = $this->model::find($id);
            if (!$product) {
                return redirect()->route('product.index')->with('error', 'Producto no encontrado');
            }

            $productExist = $this->model::where('products.code',$request->code)
            ->where('products.id','!=',$id)
            ->exists();
            if($productExist){
                return redirect()->route('product.edit',['id'=>$id])->with('error', 'El producto ya existe');
            }
            
            $product->code = $request->code;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->category_id = $request->category;
            $product->brand_id = $request->brand;
            
            if ($request->hasFile('photo')) {
                
                $rutaArchivo = 'public/'.$product->photo;
                $rutaArchivo = str_replace('/', '\\', $rutaArchivo);
        
                if (Storage::exists($rutaArchivo)) {
                    Storage::delete($rutaArchivo);
                }
        
                // Subir el nuevo archivo
                $archivo = $request->file('photo');
                $nombre = $archivo->getClientOriginalName();
                $renombrado = time() . '_' . $nombre;
                $ruta = $archivo->storeAs('products', $renombrado, 'public');
                
                $product -> photo = $ruta;
            }
            $product->save();

            return redirect()->route('product.index')->with('success', 'Producto actualizado exitosamente');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $product = $this->model::find($id);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Producto no encontrado.']);
            }

            $rutaArchivo = 'public/'.$product->photo;
            $rutaArchivo = str_replace('/', '\\', $rutaArchivo);
            
            if (Storage::exists($rutaArchivo)) {
                Storage::delete($rutaArchivo);
            }
            
            $product->delete();
        
            return response()->json(['success' => true, 'message' => 'El producto se ha eliminado exitosamente.']);
        
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>'Error al intentar eliminar el producto']);
        }
    }

    public function startStock(Request $request){

        if(!empty($request->id_product) && !empty($request->price) && !empty($request->stock)){
            $product = $this->model::find($request->id_product);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Producto no encontrado.']);
            }

            $product->price = $request->price;
            $product->stock_quantity = $request->stock;
            $product->status = 1;
            $product->save();

            return redirect()->route('product.index')->with('success', 'Stock actualizado exitosamente');
        }
        return redirect()->route('product.index')->with('error', 'debe indicar la cantidad y el precio');
        
    }
}
