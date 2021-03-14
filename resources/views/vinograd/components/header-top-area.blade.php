<div class="header-top-area black-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-5">
                <div class="header-top-left">
                    <div class="header-top-language-currency">
                        <div class="switcher">
                            <div class="language">
                                <span class="switcher-title">Ваша страна: </span>
                                <div class="switcher-menu">
                                    <ul>
                                        <li>
                                            <img src="{{Storage::url('pics/flags/'.realCurr()->code.'.png')}}">
{{--                                            <a href="#">--}}
                                            {{realCurr()->name}}
{{--                                            </a>--}}
                                            {{--                                                        <ul class="switcher-dropdown">--}}
                                            {{--                                                            <li><a href="index-5.html#">German</a></li>--}}
                                            {{--                                                            <li><a href="index-5.html#">French</a></li>--}}
                                            {{--                                                        </ul>--}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="currency">
                                <span class="switcher-title">Валюта: </span>
                                <div class="switcher-menu">
                                    <ul>
                                        <li><a href="#">{{realCurr()->sign}} {{realCurr()->code}}</a>
                                            <ul class="switcher-dropdown">
                                                @foreach($currency as $item)
                                                <li><a href="{{route('vinograd.currency', ['currency' => $item->code])}}" rel="nofollow">{{$item->sign}} {{$item->code}}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--                        <div class="col-lg-6 col-md-7">--}}
            {{--                            <!--Header Top Right Start-->--}}
            {{--                            <div class="header-top-right">--}}
            {{--                                <ul class="menu-top-menu text-md-right">--}}
            {{--                                    <li><a href="my-account.html">My Account</a></li>--}}
            {{--                                    <li><a href="wishlist.html">Wishlist</a></li>--}}
            {{--                                    <li><a href="cart.html">Shopping cart</a></li>--}}
            {{--                                    <li><a href="checkout.html">Checkout</a></li>--}}
            {{--                                    <li><a href="login-register.html">Log In</a></li>--}}
            {{--                                </ul>--}}
            {{--                            </div>--}}
            {{--                            <!--Header Top Right End-->--}}
            {{--                        </div>--}}
        </div>
    </div>
</div>
