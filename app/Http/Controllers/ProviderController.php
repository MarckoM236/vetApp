<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderStoreRequest;
use App\Http\Requests\ProviderUpdateRequest;
use App\Models\Provider;
use Illuminate\Validation\ValidationException;

class ProviderController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Provider();
    }   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = $this->model::all();
        return view('providers.index',['providers'=>$providers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('providers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderStoreRequest $request)
    {
        try{

            $providerExist = $this->model::where('providers.nit',$request->nit)
            ->exists();
            if($providerExist){
                return redirect()->route('provider.create')->with('error', 'Proveedor ya existe');
            }
            else{
                $provider = $this->model;
                $provider->nit = $request->nit;
                $provider->name = $request->name;
                $provider->contact_name = $request->contact;
                $provider->email = $request->email;
                $provider->phone = $request->phone;

                $provider->save();

                return redirect()->route('provider.index')->with('success', 'Proveedor creado exitosamente');
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
        $provider = $this->model::find($id);
        if (!$provider) {
            return redirect()->route('provider.index')->with('error', 'Proveedor no encontrado');
        }
        
        return view('providers.view',['provider' => $provider]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provider = $this->model::find($id);
        if (!$provider) {
            return redirect()->route('provider.index')->with('error', 'Proveedor no encontrado');
        }
        
        return view('providers.edit',['provider' => $provider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderUpdateRequest $request, $id)
    {
        try{

            $provider = $this->model::find($id);
            if (!$provider) {
                return response()->json(['success' => false, 'message' => 'Proveedor no encontrado.']);
            }

            $providerExist = $this->model::where('providers.nit',$request->nit)
            ->where('providers.id','!=',$id)
            ->exists();
            if($providerExist){
                return redirect()->route('provider.edit',['id'=>$id])->with('error', 'el NIT del Proveedor ya existe');
            }
            
            $provider->nit = $request->nit;
            $provider->name = $request->name;
            $provider->contact_name = $request->contact;
            $provider->email = $request->email;
            $provider->phone = $request->phone;

            $provider->save();

            return redirect()->route('provider.index')->with('success', 'Proveedor actualizado exitosamente');

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
            $provider = $this->model::find($id);
            if (!$provider) {
                return response()->json(['success' => false, 'message' => 'Proveedor no encontrado.']);
            }

            $provider->delete();
        
            return response()->json(['success' => true, 'message' => 'El proveedor ha sido eliminado exitosamente.']);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>'Error al intentar eliminar el proveedor']);
        }
    }
}
