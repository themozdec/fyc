<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>
        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">


                <li>
                    <a href="{{route('user.dashboard')}}">
                        <i data-feather="home"></i>
                        <span> {{__('user.home')}} </span>
                    </a>
                </li>
                 @if(Auth::user())
                <li class="menu-title">{{__('manager.navigation')}}</li>

                <!--li>
                    <a href="{{route('user.products.index')}}">
                        <i data-feather="server"></i>
                        <span>  {{__('user.products')}} </span>
                    </a>
                </li-->



                <li>
                    <a href="{{route('user.carts.index')}}">
                        <i data-feather="shopping-cart"></i>
                        <span>  {{__('user.carts')}} </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('user.orders.index')}}">
                        <i data-feather="shopping-bag"></i>
                        <span>  {{__('user.orders')}} </span>
                    </a>
                </li>



                <li class="menu-title">{{__('user.other')}}</li>
                <li>
                    <a href="{{route('user.favorites.index')}}">
                        <i data-feather="heart"></i>
                        <span>  {{__('user.favorites')}} </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('user.addresses.index')}}">
                        <i data-feather="map-pin"></i>
                        <span>  {{__('user.addresses')}} </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('user.setting.edit')}}">
                        <i data-feather="settings">></i>
                        <span> {{__('user.setting')}} </span>
                    </a>
                </li>
                @endif

            </ul>

            <div class="text-center mt-3 menu-title"  style="pointer-events: all;">
             
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
