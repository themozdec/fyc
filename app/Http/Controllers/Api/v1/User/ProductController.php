<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Favourite;
use App\Http\Controllers\Manager\ProductItemController;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class ProductController extends Controller
{
    public function index(Request $request): array
    {

        $user_id = $request->user()->id;
        $sub_category_ids = $request->query('sub_category_ids');
        $name = $request->query('name');
        $offer = $request->query('offer');
        if($sub_category_ids)
            $subCategories = explode(',',$sub_category_ids);
        else
            $subCategories = null;
        $products = Product::with('productImages','productItems','productItems.productItemFeatures')->where('active','=',true)->get()->toArray();
        $filterProduct = [];
        foreach ($products as $product){
            if(Favorite::where('user_id','=',$user_id)->where('product_id','=',$product['id'])->exists()){
                $product['is_favorite'] = true;
            }else{
                $product['is_favorite'] = false;
            }
            if($this->isEligible($product,$subCategories,$name,$offer)){
                array_push($filterProduct,$product);
            }

            //TODO : Add more filters
        }
        return $filterProduct;

    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'quantity'=>'required',
            'description' => 'required',
            'category' => 'required',
            'price' => 'required',
            'image' => 'required'
        ]);
            $product = new Product();
            if(isset($request->name) && $request->name!='undefined'){
            $product->name = $request->name; }
            if(isset($request->description) && $request->description!='undefined'){
            $product->description = $request->description; }
            if(isset($request->category) && $request->category!='undefined'){
            $product->category_id = $request->category;
            $product->sub_category_id = $request->category;}
            if(isset($request->image) && $request->image!='undefined'){
            $imageName = Str::random(10).'.'.$request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('product_images/', $request->image,$imageName);
            //$oldImage = $product->avatar_url;
            $data = $request->image;
            //Storage::disk('public')->delete($oldImage);
            //$product->avatar_url = "product_images/".$imageName;
            $product->shop_id = 1;
            }
            if ($product->save()) {
                $lastId = DB::getPdo()->lastInsertId();
        DB::table('product_images')->insert(
            array(
            'url'     =>   'product_images/'.$imageName, 
            'product_id'   =>   $lastId,
                 )
          );
        DB::table('product_items')->insert(
            array(
            'product_id'     =>   $lastId, 
            'price'   =>   $request->price,
            'quantity'   =>  $request->quantity,
            'revenue'   =>   10,
                 )
          );
                return response(['message' => 'Producto agregado'], 200);
        }

        return response(['errors' => ['Algo salió mal']], 403);

    }  
    private function isEligible($product,$categories,$name,$offer): bool
    {
        $eligible = true;
        if($categories){
            if(!in_array( $product['sub_category_id'],$categories))
                $eligible = $eligible && false;
        }
        if($name){
            if(!preg_match("/{$name}/i",$product['name'])){
                $eligible = $eligible && false;
            }
        }
        if($offer){
            if($product['offer']==0)
                $eligible = $eligible && false;
        }
        return $eligible;
    }

    public function show(Request $request,$id)
    {
        $user_id = $request->user()->id;
        $product = Product::with('category','productImages','shop','shop.manager','productReviews','productItems','productItems.productItemFeatures','carts')->find($id);
    
        if(Favorite::where('user_id','=',$user_id)->where('product_id','=',$product['id'])->exists()){
            $product['is_favorite'] = true;
        }else{
            $product['is_favorite'] = false;
        }
        return $product;
    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {


        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

            $product = Product::find($id);
            if(isset($request->name) && $request->name!='undefined'){
            $product->name = $request->name; }
            if(isset($request->description) && $request->description!='undefined'){
            $product->description = $request->description; }
            if(isset($request->category) && $request->category!='undefined'){
            $product->sub_category_id = $request->category; 
            $product->category_id = $request->category; }
            $product->active = true;
            $quantity = $request->quantity != 'undefined' ? $request->quantity : 'undefined';
            $price = $request->price != 'undefined' ? $request->price : 'undefined';
            
            if ($request->hasFile('image') && !empty($request->image)) {
                ProductImage::updateImage($request, $product->id);
            }
            if ($product->save()) {
                //ProductItemController::updateItems($product->id, $items);
                if($quantity!='undefined' && $price!='undefined') {
                 \DB::update("UPDATE product_items SET price=".$price.",quantity=".$quantity." WHERE product_id=".$id);
                }
                return response(['message' => 'Producto actualizado'], 200);
            } else {
                return response(['errors' => 'Algo salió mal'], 403);
            }
    }


    public function destroy($id)
    {
     ProductItemController::clearItems($id);
     \DB::delete("DELETE FROM product_images where product_id=$id");
     $product = Product::find($id);
        if($product){
            if ($product->delete()) {
             return response(['message' => ['Producto eliminado']], 200);
            }else{
             return response(['errors' => ['Algo salió mal']], 403);   
            }
        }
             
    }

    public function searchAndFilter(){

    }

    public function showReviews($productId){
        return Product::with('productReviews','productReviews.user')->find($productId);
    }

}
