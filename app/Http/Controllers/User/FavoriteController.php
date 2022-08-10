<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use PDF;
use DB;

class FavoriteController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $favorites =  Favorite::with('product','product.productImages','product.shop','product.productItems','product.productItems.productItemFeatures')
            ->where('user_id','=',$user_id)->paginate(10);

        return view('user.products.favourite-products')->with([
            'favorites'=>$favorites
        ]);
    }

    public function create()
    {

    }


    public function store(Request $request)
    {

        $user_id = auth()->user()->id;
        $this->validate($request,[
            'product_id'=>'required'
        ]);

        $favourite = Favorite::where('user_id','=',$user_id)
            ->where('product_id','=',$request->product_id)->first();

        if($favourite){
            if ($favourite->delete()) {
                return redirect()->back()->with([
                    'message'=>"Product remove from favorite"
                ]);
            }else{
                return redirect()->back()->with([
                    'error'=>"Something wrong"
                ]);
            }
        }
        $favourite = new Favorite();
        $favourite->user_id = $user_id;
        $favourite->product_id = $request->product_id;
        if ($favourite->save()) {
            return redirect()->back()->with([
                'message'=>"Product added to favorite"
            ]);
        }else{
            return redirect()->back()->with([
                'message'=>"Something wrong"
            ]);
        }
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
    $favorites = DB::select("SELECT p.name,f.created_at FROM favorites f INNER JOIN products p ON f.product_id=p.id WHERE f.user_id=$user_id;");
    view()->share('favorites',$favorites);
      
    $pdf = PDF::loadView('user.reports.favorites-pdf', $favorites);
    return $pdf->stream('Favoritos.pdf');
    }

    public function destroy(Request $request){
    }
    public function delete_favorite($product_id){
         $user_id = auth()->user()->id;
        $favourite = Favorite::where('user_id','=',$user_id)
            ->where('product_id','=',$product_id)->first();

        if($favourite){
            if ($favourite->delete()) {
                return redirect()->back()->with([
                    'message'=>"Producto eliminado de favoritos"
                ]);
            }
        }        
    }


}
