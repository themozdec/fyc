<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;



class AuthController extends Controller
{
   public function register(Request  $request){

       //sleep(3);

       $validator = Validator::make($request->all(),[
          'name'=>'required',
          'email'=>'required|email|unique:users',
          'password'=>'required'
       ]);

       if ($validator->fails())
       {
           return response(['errors'=>$validator->errors()->all()], 422);
       }

       $user  = new User();
       $user->name = $request->get('name');
       $user->email = $request->get('email');
       $user->password = Hash::make($request->get('password'));
       if(isset($request->fcm_token)){
           $user->fcm_token = $request->fcm_token;
       }
       $user->save();

       $accessToken = $user->createToken('authToken')->accessToken;
       return response(['user'=>$user,'token'=>$accessToken]);

   }


   public function login(Request $request){

       //sleep(3);

        $data = $request->validate([
           'email'=>'required|email',
           'password'=>'required'
       ]);


       if(!User::where('email', '=', $request->email)->exists()){
           return response(['errors'=>['El email no existe!']],402);
       }

       if(!Auth::guard('user')->attempt($data, $request->remember)) {
           return response(['errors'=>['ContraseÃ±a incorrecta']],402);
       }

       $accessToken = auth()->user()->createToken('authToken')->accessToken;
       if(isset($request->fcm_token)){
           $user = User::find(auth()->user()->id);
           $user->fcm_token = $request->fcm_token;
           $user->save();
       }
       return response(['user'=> auth()->user(),'token'=>$accessToken],200);
   }


   public function updateProfile(Request $request){

//       return response(['errors' => ['This is demo version' ]], 403);
       $user = User::find(auth()->user()->id);
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
       }else{
           return response(['errors'=>['Algo sali«Ñ mal']],402);
       }
   }

   public function verifyMobileNumber(Request $request){

       $validator = Validator::make($request->all(),[
           'mobile'=>'required',

       ]);

       if ($validator->fails())
       {
           return response(['errors'=>$validator->errors()->all()], 422);
       }

       if(User::where('mobile',$request->mobile)->exists()){
           return response(['errors'=>['Este n«âmero ya existe']],402);

       }else{
           return response(['message'=>['Tu puedes verificarte con este n«âmero']]);
       }
   }

   public function mobileVerified(Request $request){

       $validator = Validator::make($request->all(),[
           'mobile'=>'required',

       ]);

       if ($validator->fails())
       {
           return response(['errors'=>$validator->errors()->all()], 422);
       }


       $user =  auth()->user();


       $user->mobile=$request->get('mobile');
       $user->mobile_verified=true;


       if($user->save()){
           return response(['message'=>['Tu configuraci«Ñn ha sido cambiada'],'user'=>$user],200);
       }else{
           return response(['errors'=>['Algo sali«Ñ mal']],402);
       }
   }
}

