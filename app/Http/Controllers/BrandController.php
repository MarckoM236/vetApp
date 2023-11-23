<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Brand();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->model::all();
        return view('brands.index',['brands'=>$brands]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        try{

            $brand_sh = strtolower($request->brand);
            $brand = $this->model::where('name', 'like', '%' . $brand_sh . '%')->first();
            if ($brand) {
                return redirect()->route('brand.create')->with('error', 'Ya existe la marca');
            }

            $brand_qr=$this->model;
            $brand_qr->name = $request->brand;
            $brand_qr->save();
            return redirect()->route('brand.index')->with('success', 'Marca registrada exitoisamente');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = $this->model::find($id);
        if (!$brand) {
            return redirect()->route('brand.index')->with('error', 'Marca no encontrada');
        }
        
        return view('brands.edit',['brand' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        try{
            
            $brand_qr = $this->model::find($id);
            if (!$brand_qr) {
                return redirect()->route('brand.index')->with('error', 'Marca No encontrada');
            }

            $brand_sh = strtolower($request->brand);
            $brand = $this->model::where('name', 'like', '%' . $brand_sh . '%')->where('id','!=', $id)->first();
            if ($brand) {
                return redirect()->route('brand.edit',['id'=>$id])->with('error', 'Ya existe la marca');
            }

            $brand_qr->name = $request->brand;
            $brand_qr->save();
            return redirect()->route('brand.index')->with('success', 'Marca actualizada exitosamente');

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
            $brand = $this->model::find($id);
            if (!$brand) {
                return response()->json(['success' => false, 'message' => 'Marca no encontrada.']);
            }
            
            $brand->delete();
        
            return response()->json(['success' => true, 'message' => 'La Marca ha sido eliminada exitosamente.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'No se pudo eliminar la marca']);
        }
    }
}
