<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manager\ProductItemController;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    //Todo: Add auth validations

    public function index()
    {
        $users = User::paginate(7);

        return view('admin.users.users')->with([
            'users' => $users
        ]);
    }




    public function create(Request $request)
    {
    return view('admin.users.create-user');
    }
    public function store(Request $request)
    {
      $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
            
        ],
            [
                'name.required' => 'Por favor ingresa un nombre para el usuario',
                'email.required' => 'Por favor ingresa una dirección de correo',
                //'mobile.required' => 'Por favor ingresa un número de teléfono',
                'password.required' => 'Por favor ingresa una contraseña'

            ]
        );

            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            //$user->mobile = $request->get('mobile');
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                return redirect()->route('admin.users.index')->with('message', 'Usuario creado correctamente');
            } else {
                return redirect()->route('admin.users.index')->with('error', 'Algo salió mal');
            }
        return redirect()->route('admin.users.index')->with('error', 'Algo salió mal');

    }
    

    public function show($id)
    {


    }


    public function edit($id)
    {

        $user = User::find($id);
        return view('admin.users.edit-user')->with([
            'user'=>$user
        ]);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            //'password' => 'required',
        ]);


        $user= User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        if(isset($request->blocked)){
            $user->blocked = true;
        }else{
            $user->blocked = false;
        }

        if($user->save()) {
            return redirect(route('admin.users.index'))->with([
                'message' => 'Usuario Actualizado'
            ]);
        }else{
            return redirect()->back()->with([
                'error' => 'Algo salió mal'
            ]);
        }
    }

    public function destroy($id)
    {
    $user = User::find($id);
        if($user){
            if ($user->delete()) {
                return redirect()->back()->with([
                    'message'=>"Usuario eliminado correctamente"
                ]);
            }
        }
             
    }

}
