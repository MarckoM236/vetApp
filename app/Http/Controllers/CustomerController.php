<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Customer();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = $this->model::all();
        return view('customers.index',['customers'=>$customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'identificacion' => ['required', 'numeric', 'min:7','unique:customers'],
                'name' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'address' => ['nullable', 'string', 'max:255'],
                'phone' => ['nullable', 'numeric', 'min:7'],
                'city' => ['nullable', 'string', 'max:255'],
                'neighborhood' => ['nullable','string', 'max:255']
            ]);

            $customerExist = $this->model::where('customers.identificacion',$request->identificacion)
            ->exists();
            if($customerExist){
                return redirect()->route('customer.create')->with('error', 'Cliente ya existe');
            }
            else{
                $customer = $this->model;
                $customer->identificacion = $request->identificacion;
                $customer->name = $request->name;
                $customer->lastName = $request->lastName;
                $customer->email = $request->email;
                $customer->address = $request->address;
                $customer->phone = $request->phone;
                $customer->city = $request->city;
                $customer->neighborhood = $request->neighborhood;
                
                $customer->save();

                return redirect()->route('customer.index')->with('success', 'Cliente creado exitosamente');
            }

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
        $customer = $this->model::find($id);
        if (!$customer) {
            return redirect()->route('customer.index')->with('error', 'Cliente no encontrado');
        }
        
        return view('customers.view',['customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = $this->model::find($id);
        if (!$customer) {
            return redirect()->route('customer.index')->with('error', 'Cliente no encontrado');
        }
        
        return view('customers.edit',['customer' => $customer]);
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
        try{
            $request->validate([
                'identificacion' => ['required', 'numeric', 'min:7'],
                'name' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'address' => ['nullable', 'string', 'max:255'],
                'phone' => ['nullable', 'numeric', 'min:7'],
                'city' => ['nullable', 'string', 'max:255'],
                'neighborhood' => ['nullable','string', 'max:255']
            ]);
            $customer = $this->model::find($id);
            if (!$customer) {
                return redirect()->route('customer.index')->with('error', 'Cliente no encontrado');
            }

            $customerExist = $this->model::where('customers.identificacion',$request->identificacion)
            ->where('id','!=',$id)
            ->exists();

            if($customerExist){
                return redirect()->route('customer.edit',['id'=>$id])->with('error', 'Cliente ya existe');
            }
            else{
                $customer->identificacion = $request->identificacion;
                $customer->name = $request->name;
                $customer->lastName = $request->lastName;
                $customer->email = $request->email;
                $customer->address = $request->address;
                $customer->phone = $request->phone;
                $customer->city = $request->city;
                $customer->neighborhood = $request->neighborhood;
                
                $customer->save();

                return redirect()->route('customer.index')->with('success', 'Cliente actualizado exitosamente');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
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
            $customer = $this->model::find($id);
            if (!$customer) {
                return response()->json(['success' => false, 'message' => 'Cliente no encontrado.']);
            }

            $customer->delete();
        
            return response()->json(['success' => true, 'message' => 'El Cliente ha sido eliminado correctamente.']);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>'Error al intentar eliminar el cliente']);
        }
    }
}
