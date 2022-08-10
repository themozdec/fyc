<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use PDF;
use DB;

class UserAddressController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;

        $addresses =  UserAddress::where('user_id',$user_id)->where('active',true)->get();
        return view('user.addresses.addresses')->with([
            'addresses'=>$addresses
        ]);
    }

    public function create()
    {
        return view('user.addresses.create-address');
    }


    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $this->validate($request,[
           'longitude'=>'required',
           'latitude'=>'required',
           'address'=>'required',
           'city'=>'required',
           'pincode'=>'required',
        ]);

        $address = new UserAddress();
        $address->longitude = $request->longitude;
        $address->latitude = $request->latitude;
        $address->address = $request->address;
        $address->address2 = $request->address2;
        $address->city = $request->city;
        $address->pincode = $request->pincode;
        $address->user_id = $user_id;

        if ($address->save()) {
            return redirect()->back()->with([
                'message' => 'Dirección agregada'
            ]);
        }
        return redirect()->back()->with([
            'error' => 'Algo ha salido mal'
        ]);
    }

    public function show($id)
    {
    }


    public function edit($id)
    {

    }


    public function update(Request $request)
    {

    }
    public function pdf()
    {
    $user_id = auth()->user()->id;
    $address = DB::select("SELECT address,city,pincode FROM user_addresses WHERE user_id=$user_id;");
    view()->share('address',$address);
      
    $pdf = PDF::loadView('user.reports.address-pdf', $address);
    return $pdf->stream('Direcciones.pdf');
    }

    public function destroy($id){

        $userAddress = UserAddress::find($id);
        if($userAddress->delete()){
            //return response(['message' => 'Dirección eliminada!'], 200);
            return redirect()->back()->with(['message' => 'Dirección eliminada!'], 200);
                
        }else{
            return redirect()->back()->with([
            'errors' => ['Algo ha salido mal']], 403);
            //return response(['errors' => ['Algo ha salido mal']], 403);
        }


    }

}
