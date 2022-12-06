    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!--Modal Img-->
                    <div class="col-md-5">
                        <!--Modal Tab Content Start-->
                        <div class="tab-content product-details-large" id="myTabContent">
                            <div class="tab-pane fade show active" id="single-slide1" role="tabpanel" aria-labelledby="single-slide-tab-1">
                                <!--Single Product Image Start-->
                                <div class="single-product-img img-full">
                                    <img src="{{ asset($product->getImage('700x700')) }}" alt="{{ $product->title }}">
                                </div>
                                <!--Single Product Image End-->
                            </div>

                            @foreach($product->getGallery('700x700') as $image)
                                <div class="tab-pane fade" id="single-slide{{$loop->iteration + 1}}" role="tabpanel" aria-labelledby="single-slide-tab-{{$loop->iteration + 1}}">
                                    <div class="single-product-img img-full">
                                        <img src="{{Storage::url($image)}}" alt="{{ $product->title }}">
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <!--Modal Content End-->
                        <!--Modal Tab Menu Start-->
                        <div class="single-product-menu">
                            <div class="nav single-slide-menu owl-carousel" role="tablist">
                                <div class="single-tab-menu img-full">
                                    <a class="active" data-toggle="tab" id="single-slide-tab-1" href="#single-slide1" rel="nofollow">
                                        <img src="{{ asset($product->getImage('100x100')) }}" alt="{{ $product->title }}">
                                    </a>
                                </div>

                                @foreach($product->getGallery('100x100') as $image)
                                    <div class="single-tab-menu img-full">
                                        <a data-toggle="tab" id="single-slide-tab-{{$loop->iteration + 1}}" href="#single-slide{{$loop->iteration + 1}}" rel="nofollow">
                                            <img src="{{Storage::url($image)}}" alt="{{ $product->title }}">
                                        </a>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <!--Modal Tab Menu End-->
                    </div>
                    <!--Modal Img-->
                    <!--Modal Content-->
                    <div class="col-md-7">
                        <div class="modal-product-info">
                            <h1>{{ $product->name }}</h1>
{{--                            <div class="modal-product-price">--}}
{{--                                <span class="old-price">$74.00</span>--}}
{{--                                <span class="new-price">${{ $product->price }}</span>--}}
{{--                            </div>--}}

                            <table class="table table-sm  table-hover">
                                <tbody>
                                <tr>
                                    <th scope="row"><span class="stock in-stock"></span>Срок созревания</th>
                                    <td>{{$product->category::getRipeningName($product->ripening)}} дней</td>
                                </tr>
                                <tr>
                                    <th scope="row"><span class="stock in-stock"></span>Масса грозди</th>
                                    <td>{{ $product->props['mass'] }} г</td>
                                </tr>
                                <tr>
                                    <th scope="row"><span class="stock in-stock"></span>Окраска</th>
                                    <td>{{ $product->props['color'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><span class="stock in-stock"></span>Вкус</th>
                                    <td>{{ $product->props['flavor'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><span class="stock in-stock"></span>Морозоустойчивость</th>
                                    <td>{{ $product->props['frost'] }} &#8451;</td>
                                </tr>
{{--                                <tr>--}}
{{--                                    <th scope="row"><span class="stock in-stock"></span>Устойчивость к болезням</th>--}}
{{--                                    <td>средняя</td>--}}
{{--                                </tr>--}}
                                <tr>
                                    <th scope="row"><span class="stock in-stock"></span>Цветок</th>
                                    <td>{{ $product->props['flower'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><span class="stock in-stock"></span>Категориия</th>
                                    <td>
                                        <a href="{{route('vinograd.category.category', ['slug' => $product->category->slug])}}"> {{$product->category->name}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><span class="stock in-stock"></span>Селекция</th>
                                    <td>
                                        @if($product->selection->id > 1)
                                            <a href="{{route('vinograd.category.selection', ['slug' => $product->selection->slug])}}"> {{$product->selection->name}}</a>,
                                        @endif
                                        @if($product->country->id > 1)
                                            <a href="{{route('vinograd.category.country', ['slug' => $product->country->slug])}}"> {{$product->country->name}}</a>
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>

{{--                            <a href="single-product.html" class="see-all">Полное описание сорта</a>--}}
{{--                            <div class="add-to-cart quantity">--}}
{{--                                <form class="add-quantity" action="index.html#">--}}
{{--                                    <div class="modal-quantity">--}}
{{--                                        <input type="number" value="1">--}}
{{--                                    </div>--}}
{{--                                    <div class="add-to-link">--}}
{{--                                        <button class="form-button" data-text="add to cart">add to cart</button>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}

                            <div class="single-product-quantity">
                                <ul class="list-group">
                                    <h3>У нас в продаже</h3>
                                    @forelse($product->getModifications() as $modification)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span style="max-width: 50%;"><strong>{{$modification->property->name}}</strong> - {{$modification->price}}руб.</span>
                                            <div>
                                                {{Form::open(['route'=>['vinograd.cart.add'], 'class' => 'add-quantity'])}}
                                                <div class="product-quantity">
                                                    {{Form::number('quantity', 1)}}
                                                    {{Form::hidden('product_id', $product->id)}}
                                                    {{Form::hidden('modification_id', $modification->id)}}
                                                </div>
                                                <button class="product-btn"></button>
                                                {{Form::close()}}
                                            </div>
                                        </li>
                                    @empty
                                        <p class="text-danger">Нет в наличии</p>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="wishlist-compare-btn">
                                <a href="{{route('vinograd.cabinet.wishlist.add', ['id' => $product->id])}}" class="wishlist-btn" rel="nofollow">Отложить</a>
                                <a href="#" class="compare add-compare" data-product-id="{{$product->id}}" data-url="{{route('vinograd.compare.add')}}" data-action="add" rel="nofollow">В сравнение</a>
                            </div>
{{--                            <div class="product-meta">--}}
{{--                        <span class="posted-in">--}}
{{--                            <a href="{{route('vinograd.product', ['slug' => $product->slug])}}">Полное описание сорта</a>--}}
{{--                        </span>--}}
{{--                            </div>--}}

                        </div>
                    </div>
                    <!--Modal Content-->
                </div>
                <div class="row">
                    <div class="col">
                        <div class="cart-description">
                            <p>{!! $product->description !!}</p>
                            <a href="{{route('vinograd.product', ['slug' => $product->slug])}}" class="btn btn-success" role="button">Виноград {{ $product->name }} - описание сорта и характеристики</a>
                        </div>
                        <div class="social-share mb-5 text-center">
                            <ul class="socil-icon2">
                                <li><a href="https://www.facebook.com/Minsk.Vinograd/" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UC5-E2vxUNeMUqAYSDCFO23w" rel="nofollow"><i class="fa fa-youtube"></i></a></li>
                                <li><a href="https://zen.yandex.ru/id/5c57c7f3ea64bc00ac1eb86e"><img src="{{Storage::url('pics/img/logo/yandex-zen.png')}}"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
