@extends('user.layouts.app', ['title' => 'Favoritos'])

@section('css')
@endsection

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">
        <x-alert></x-alert>

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">{{env('APP_NAME')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('user.favorite_product')}}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{__('user.favorite_product')}}</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    @if(count($favorites)>0)
                        
                         <form action="{{url('favorite_excel')}}" method="get">
                                                        @csrf
                                                        <input type="hidden" name="shop_id" value="}}">
                                                    <div class="row">   
                                                    <div class="col-md-6">  
                                                    <button
                                                       class="btn btn-secondary"><!--i class="mdi mdi-cart-plus mr-1"></i-->
                                                        Excel </button></form></div>
                                                    <div class="col">     
                                                        <form action="{{url('favorite_pdf')}}" method="get">
                                                        @csrf
                                                        <input type="hidden" name="shop_id" value="">
                                                    <button
                                                       class="btn btn-secondary"><!--i class="mdi mdi-cart-plus mr-1"></i-->
                                                        PDF </button></form>
                                                       
                                                        </div></div>
                                                         @foreach($favorites as $favorite)
                            <div class="col-sm-6 col-md-4 col-xl-2 col-lg-3">
                                <div class="card-box product-box">

                                    <div class="bg-light">
                                         <form action="{{url('delete_favorite',['product_id'=>$favorite->product->id])}}" method="get">
                                                        @csrf
                                                        <!--input type="hidden" name="" value=""-->
                                                    <div class="row">   
                                                    <div class="col-md-4">  
                                                    <button
                                                       class="btn btn btn-link"><!--i class="mdi mdi-cart-plus mr-1"></i-->
                                                        Delete </button></form></div>

                                        @if(count($favorite->product['productImages'])!=0)
                                            <img
                                                src="{{asset('storage/'.$favorite->product['productImages'][0]['url'])}}"
                                                style="object-fit: cover" alt="OOps"
                                                class="img-fluid"
                                            >
                                        @else
                                            <img src="{{\App\Models\Product::getPlaceholderImage()}}"
                                                 style="object-fit: cover" alt="OOps"
                                                 class="img-fluid">
                                        @endif

                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a
                                                        href="{{route('user.products.show',['id'=>$favorite->product->id])}}"
                                                        class="text-dark">{{$favorite->product->name}}</a></h5>
                                                <div class="">
                                                   {{-- @for($i=1;$i<6;$i++)
                                                        @if($favorite->product->rating >= $i)
                                                            <i class="fa fa-star text-success"></i>
                                                        @else
                                                            <i class="fa fa-star text-light"></i>
                                                        @endif
                                                    @endfor
                                                    <span
                                                        class=""> ({{$favorite->product->total_rating}} {{__('user.reviews')}})</span>--}}
                                                </div>
                                                {{--<h5 class="mt-2"><span
                                                        class="text-muted"> {{count($favorite->product['productItems'])}} {{__('user.types_of_items_available')}}</span>
                                                </h5>--}}
                                            </div>
                                         </div></div></div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                     @endforeach
                                </div> <!-- end card-box-->
                                
                            </div>
                       
                    @else
                        <div class="col">
                            <p class="text-center h4 font-weight-bold">{{__('user.you_have_not_any_favorite_item_yet')}}</p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- end card-->
            <div class="float-right">
                {{$favorites->links()}}
            </div>

        </div> <!-- container -->

@endsection

@section('script')
@endsection
