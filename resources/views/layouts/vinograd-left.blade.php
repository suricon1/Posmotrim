@extends('layouts.vinograd')

@section('header-top-area')
    @include('vinograd.components.header-top-area', ['currency' => $currency])
@endsection

@section('breadcrumb')
    <div class="breadcrumb-tow mb-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content breadcrumb-content-tow">
                        <ul>
                            <li><a href="{{route('vinograd.home')}}"><i class="fa fa-home"></i></a></li>
                            @yield('breadcrumb-content')
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="blog-area white-bg pt-4 pb-0 mb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-2">

                    @yield('section-title')

                    @yield('left-content')

                </div>
                <div class="col-lg-3 order-lg-1">
                    <div class="blog_sidebar">
                        <div class="row_products_side">
                            <div class="product_left_sidbar">
                                {{--@section('left_sidbar')--}}
                                    @include('vinograd.components.left_sidebar')
                                {{--@show--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="about-us-area-2">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <div class="about-us-content-2">--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            <h4 class="alert-heading">Закон "О селекции и семеноводстве"</h4>--}}
{{--                            <p>--}}
{{--                                В связи с действием Закона <strong>"О селекции и семеноводстве сельскохозяйственных растений"</strong> черенки и саженцы винограда мы раздаём на <strong>безвозмездной</strong> основе.<br>--}}
{{--                                Суммы, указанные на нашем сайте, мы просим лишь за упаковку.--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    @yield('category-content')
    @include('vinograd.components.look-product')

@endsection

@section('scripts')
    <script src="/site/js/owl.carousel.min.js"></script>
@endsection
