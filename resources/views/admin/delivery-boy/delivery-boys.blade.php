@extends('admin.layouts.app', ['title' => 'Delivery boy'])

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
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{env('APP_NAME')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('admin.delivery_boy')}}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{__('admin.delivery_boy')}}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">

                        <div class="float-right mr-2">
                            {{ $delivery_boys->links() }}
                        </div>
                        <div class="col-12 mt-3">

                            @if($delivery_boys->count()>0)

                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-hover mb-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>{{__('admin.image')}}</th>
                                            <th>{{__('admin.name')}}</th>
                                            <th>{{__('admin.status')}}</th>
                                            <th>{{__('admin.rating')}}</th>
                                            <th>{{__('admin.orders')}}</th>
                                            <th>{{__('admin.revenue')}}</th>
                                            <th style="width: 82px;">{{__('admin.action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($delivery_boys as $delivery_boy)
                                            <tr>
                                                <td>{{$delivery_boy->id}}
                                                </td>
                                                <td>

                                                    <img
                                                        src="{{\App\Helpers\TextUtil::getImageUrl($delivery_boy['avatar_url'],\App\Helpers\TextUtil::$PLACEHOLDER_AVATAR_URL)}}"
                                                        alt="image" class="img-fluid avatar-sm rounded-circle">
                                                </td>
                                                <td>{{$delivery_boy->name}}</td>
                                                <td>
                                                    @if($delivery_boy->is_offline)
                                                        <span class="bg-danger mr-1"
                                                              style="border-radius: 50%;width: 8px;height: 8px;  display: inline-block;"></span> {{__('admin.offline')}}
                                                    @else
                                                        <span class="bg-primary mr-1"
                                                              style="border-radius: 50%;width: 8px;height: 8px;  display: inline-block;"></span> {{__('admin.online')}}
                                                    @endif

                                                </td>
                                                <td>
                                                    @for($i=0;$i<5;$i++)
                                                        <i class="mdi @if($i<$delivery_boy['rating']) mdi-star @else mdi-star-outline @endif"
                                                           style="font-size: 18px; margin-left: -4px; color: @if($i<$delivery_boy['rating'])  {{\App\Helpers\ColorUtil::getColorFromRating($delivery_boy['rating'])}} @else black @endif"></i>
                                                    @endfor
                                                    <p class="d-inline">({{$delivery_boy['total_rating']}})</p>
                                                </td>
                                                <td>{{$delivery_boy->orders_count}}</td>
                                                <td>{{\App\Helpers\AppSetting::$currencySign}} {{\App\Helpers\CurrencyUtil::doubleToString($delivery_boy->revenue)}}</td>
                                                <td>
                                                    <a href="{{route('admin.delivery-boy.reviews.show',['id'=>$delivery_boy->id])}}"
                                                       style="font-size: 20px"> <i
                                                            class="mdi mdi-star "></i></a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            @else
                                <h3>{{__('admin.there_is_no_shop_yet')}}</h3>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('script')

@endsection
