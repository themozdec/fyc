<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductItem;
use Illuminate\Http\Request;
use PDF;
use DB;

class CartController extends Controller
{
    //TODO : ADD Validator when item quantity is not available

    public function index(Request $request)
    {
        $user_id = auth()->user()->id;

        $carts = Cart::where('user_id', '=', $user_id)
            ->where('active', '=', true)->get();
        $shopIds = collect();
        foreach ($carts as $cart){
            $shopIds->add($cart->shop_id);
        }

        $shopIds = $shopIds->unique()->values()->all();

        $filterCart = [];
        foreach ($shopIds as $shopId){

            $carts = Cart::with('product', 'product.shop', 'product.category', 'product.productImages', 'product.shop.manager','productItem','productItem.productItemFeatures')->where('user_id', '=', $user_id)
                ->where('active', '=', true)->where('shop_id',$shopId)->get();
            array_push($filterCart,$carts);
        }



        return view('user.carts.carts')->with([
            'filterCarts'=>$filterCart
        ]);
    }

    public function create()
    {

    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'product_item_id'=>'required',
        ]);

        $productItem = ProductItem::with('product')->find($request->product_item_id);

        $product = $productItem->product;
        $quantity = isset($request->quantity) ? $request->quantity : 1;

        $user_id = auth()->user()->id;
        $cart = Cart::where('product_item_id', '=', $request->product_item_id)
            ->where('user_id', '=', $user_id)
            ->where('active', '=', true)
            ->exists();
        if (!$cart) {
            if($quantity > $productItem->quantity){
                return redirect()->back()->with([
                    'error' => 'Cantidad no disponible'
                ]);
            }

            if(!$product->active){
                return redirect()->back()->with([
                    'error' => 'Este producto actualmente no está activo'
                ]);
            }

            $cart = new Cart();
            $cart->product_id = $product->id;
            $cart->product_item_id = $productItem->id;
            $cart->user_id = $user_id;
            $cart->shop_id = $product->shop_id;
            $cart->quantity = $quantity;
            if ($cart->save()) {
                return redirect()->back()->with([
                    'message' => 'Producto agregado al carrito'
                ]);
            }

        }
        else {
            return redirect()->back()->with([
                'error' => 'Este producto ya está en el carrito'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Algo salió mal'
        ]);

    }

    public function show($id)
    {
    }


    public function edit($id)
    {

    }
     public function pdf()
    {
    $user_id = auth()->user()->id;
    $carts = DB::select("SELECT p.name,p.description,c.quantity,p2.price FROM carts c INNER JOIN products p ON c.product_id=p.id INNER JOIN product_items p2 ON c.product_id=p2.id WHERE c.user_id=$user_id AND c.active=1;");
    view()->share('carts',$carts);
      
    $pdf = PDF::loadView('user.reports.cart-pdf', $carts);
    return $pdf->stream('micarrito.pdf');
    }


    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'quantity'=>'required'
        ]);

        $cart = Cart::with('productItem')->find($id);
        if ($cart) {
            if($request->quantity > $cart->productItem->quantity){
                return redirect()->back()->with([
                    'error' => 'Cantidad no disponible'
                ]);
            }
            $cart->quantity = $request->quantity;
            if ($cart->save()) {
                return redirect()->back();
            }
        }
        return redirect()->back()->with([
            'error' => 'Algo salió mal'
        ]);
    }


    public function destroy(Request $request)
    {

        $this->validate($request, [
            'cart_id'=>'required',
        ]);
        $cart = Cart::find($request->cart_id);
        if($cart->delete()){
            return redirect()->back()->with([
                'message' => 'Producto eliminado del carrito'
            ]);
        }else{
            return redirect()->back()->with([
                'error' => 'Algo salió mal'
            ]);
        }

    }

}
