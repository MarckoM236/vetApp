<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Category();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->model::all();
        return view('categories.index',['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
            'category'=>['required', 'string', 'max:255']
        ]);

        $category_sh = strtolower($request->category);
        $category = $this->model::where('name', 'like', '%' . $category_sh . '%')->first();
        if ($category) {
            return redirect()->route('category.create')->with('error', 'Ya existe la categoria');
        }

        $category_qr=$this->model;
        $category_qr->name = $request->category;
        $category_qr->save();
        return redirect()->route('category.index')->with('success', 'Categoria registrada exitoisamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->model::find($id);
        if (!$category) {
            return redirect()->route('category.index')->with('error', 'Categoria no encontrada');
        }
        
        return view('categories.edit',['category' => $category]);
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
        $request->validate([
            'category'=>['required', 'string', 'max:255']
        ]);
        $category_qr = $this->model::find($id);
        if (!$category_qr) {
            return redirect()->route('category.index')->with('error', 'Categoria No encontrada');
        }

        $category_sh = strtolower($request->category);
        $category = $this->model::where('name', 'like', '%' . $category_sh . '%')->where('id','!=', $id)->first();
        if ($category) {
            return redirect()->route('category.edit',['id'=>$id])->with('error', 'Ya existe la categoria');
        }

        $category_qr->name = $request->category;
        $category_qr->save();
        return redirect()->route('category.index')->with('success', 'Categoria registrada exitoisamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->model::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Categoria no encontrada.']);
        }
        
        $category->delete();
    
        return response()->json(['success' => true, 'message' => 'La categoria ha sido eliminada exitosamente.']);
    }
}
