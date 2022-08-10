<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Helpers\AppSetting;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
public function index(Request $request)
    {
        $users = User::all();
        //return response(['users' => $users], 200);
        return $users;
    }
public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email'=>'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', '=', $request->email)->exists();
         if (!$user) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if(isset($request->avatar_image)){
            $imageName = Str::random(10).'.'.$request->avatar_image->getClientOriginalExtension();
            //$url = "user_avatars/".Str::random(10).'.'.$request->avatar_image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('user_avatars/', $request->avatar_image,$imageName);
            $oldImage = $user->avatar_url;
            $data = $request->avatar_image;
            //Storage::disk('public')->put($url, $data);
            Storage::disk('public')->delete($oldImage);
            $user->avatar_url = "user_avatars/".$imageName;
            }
            if ($user->save()) {
                return response(['message' => 'Usuario agregado'], 200);
            }

        } else {
            return response(['errors' => ['Este email ya está registrado']], 403);
        }

        return response(['errors' => ['Algo salió mal']], 403);

    }  
    public function show(Request $request,$id)
    {
        $user = User::find($id);
        return $user;
    }
    public function update(Request $request,$id){

      $user = User::where('email', '=', $request->email)->where('id','!=',$id)->exists();
      if (!$user) {
       $user = User::find($id);
       if(isset($request->name) && $request->name!='undefined'){
           $user->name = $request->name;
       }
       if(isset($request->email) && $request->email!='undefined'){
           $user->email = $request->email;
       }
       if(isset($request->password) && $request->password!='undefined'){
           $user->password = Hash::make($request->password);
       }

       if(isset($request->avatar_image) && $request->avatar_image!='undefined'){
          $imageName = Str::random(10).'.'.$request->avatar_image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('user_avatars/', $request->avatar_image,$imageName);
            $oldImage = $user->avatar_url;
            $data = $request->avatar_image;
            Storage::disk('public')->delete($oldImage);
            $user->avatar_url = "user_avatars/".$imageName;
       }

       if($user->save()){
           return response(['message'=>['Datos guardados'],'user'=>$user]);
       }
       } else {
            return response(['errors' => ['Este email ya está registrado']], 403);
        }
           return response(['errors'=>['Algo sali«Ñ mal']],402);
       
   }
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->delete()){
            return response(['message' => 'Usuario eliminado'], 200);
        }else{
            return response(['errors' => ['Algo salió mal']], 403);
        }

    }  
}
