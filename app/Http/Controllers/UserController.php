<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->model::join('roles','users.role_id','=','roles.id')
        ->select('users.id as id','users.identificacion as identificacion','users.name as name','users.lastName as lastName',
        'users.email as email','users.status as status','roles.descript as role')
        ->get();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'identificacion' => ['required', 'string', 'max:255','unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $userExist = $this->model::where('users.identificacion',$request->identificacion)
        ->exists();
        if($userExist){
            return redirect()->route('user.create')->with('error', 'Usuario ya existe');
        }
        else{
            $user = $this->model;
            $user->identificacion = $request->identificacion;
            $user->name = $request->name;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role_id = $request->role ? $request->role : 2;

            if ($request->hasFile('photo')) {

                $archivo = $request->file('photo');
                $nombre = $archivo->getClientOriginalName();
                $renombrado = time() . '_' . $nombre;
                $ruta = $archivo->storeAs('profile', $renombrado, 'public');
                
                $user->photo = $ruta;
            }
            $user->save();

            return redirect()->route('user.index')->with('success', 'Usuario creado exitosamente');
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
        $user = $this->model::find($id);
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'Usuario no encontrado');
        }
        
        return view('users.view',['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->model::find($id);
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'Usuario no encontrado');
        }
        
        return view('users.edit',['user' => $user]);
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
            'identificacion' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'required_if:switch,on', 'string', 'min:8', 'confirmed']
        ]);

        $user = $this->model::find($id);
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'Usuario no encontrado');
        }

        $userExist = $this->model::where('users.email',$request->email)
        ->where('id','!=',$id)
        ->exists();

        if($userExist){
            return redirect()->route('user.edit',['id'=>$id])->with('error', 'Usuario ya existe');
        }

        if(!$request->password==null){
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            
            $rutaArchivo = 'public/'.$user->photo;
            $rutaArchivo = str_replace('/', '\\', $rutaArchivo);
    
            if (Storage::exists($rutaArchivo)) {
                Storage::delete($rutaArchivo);
            }
    
            // Subir el nuevo archivo
            $archivo = $request->file('photo');
            $nombre = $archivo->getClientOriginalName();
            $renombrado = time() . '_' . $nombre;
            $ruta = $archivo->storeAs('profile', $renombrado, 'public');
            
            $user -> photo = $ruta;
        }

        $user->identificacion = $request->identificacion;
        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->role_id = $request->role ? $request->role : 2;
        $user->save();

        return redirect()->route('user.index')->with('success', 'Usuario actualizado exitosamente');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->model::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado.']);
        }

        $rutaArchivo = 'public/'.$user->photo;
        $rutaArchivo = str_replace('/', '\\', $rutaArchivo);
        
        if (Storage::exists($rutaArchivo)) {
            Storage::delete($rutaArchivo);
        }
        
        $user->delete();
    
        return response()->json(['success' => true, 'message' => 'El usuario ha sido eliminado correctamente.']);
    
    }

    public function updateStatus(Request $request, $id){
        $user = $this->model::find($id);
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'Usuario no encontrado');
        }

        $user->status = $request->status;
        $user->save();

        if($request->status == 1){
            return redirect()->route('user.index')->with('success', 'Se habilito el usuario exitosamente');
        }
        else{
            return redirect()->route('user.index')->with('success', 'Se deshabilito el usuario exitosamente');
        }
    }
}
