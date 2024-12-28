<div class="product-list-view">

    @foreach($products as $product)
{{--        @php $modifications = $product->getModifications(); @endphp--}}
        <div class="product-list-item mb-5">
            <div class="row">
                <div class="col-md-5">
                    <div class="single-product">
                        <div class="product-img img-full">
                            <a href="{{route('vinograd.product', ['slug' => $product->slug])}}">
                                <img src="{{asset($product->getImage('700x700'))}}" alt="{{ $product->title }}">
                            </a>
                            {{--                                                <span class="onsale">Sale!</span>--}}
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="product-content shop-list">
                        <h2><a href="{{route('vinograd.product', ['slug' => $product->slug])}}">{{ $product->name }}</a></h2>
                        {{--                                            <div class="product-reviews">--}}
                        {{--                                                <i class="fa fa-star"></i>--}}
                        {{--                                                <i class="fa fa-star"></i>--}}
                        {{--                                                <i class="fa fa-star"></i>--}}
                        {{--                                                <i class="fa fa-star"></i>--}}
                        {{--                                                <i class="fa fa-star-o"></i>--}}
                        {{--                                            </div>--}}
                        <div class="product-description">
                            <p>{!! $product->description !!}</p>
                        </div>
                        <div class="product-price">
                            <ul class="list-group">
{{--                                @forelse($modifications as $modification)--}}
                                @forelse($product->modifications as $modification)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            {{$modification->property->name}} - <strong>{{currency($modification->price)}} {{signature()}}</strong>
                                        </span>
                                        {{Form::open(['route'=>['vinograd.cart.add'], 'class' => 'add-quantity', 'data-action' => 'add-to-cart'])}}
                                        {{Form::hidden('product_id', $product->id)}}
                                        {{Form::hidden('modification_id', $modification->id)}}
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon2">шт</span>
                                            </div>
                                            {{Form::number('quantity', 1, ['class' => 'form-control'])}}
                                            <div class="input-group-append" id="button-addon4">
                                                {{Form::button('', ['class' => 'product-btn', 'type' => 'submit'])}}
                                            </div>
                                        </div>
                                        {{Form::close()}}
                                    </li>
                                @empty
{{--                                    {!! config('main.empty_text_info') !!}--}}
                                    <span class="text-danger">Нет в наличии</span>
                                @endforelse

                            </ul>
                        </div>
                        <div class="product-list-action">
                            <ul>
                                <li><a href="#" class="open-modal" data-toggle="modal" data-product-id="{{$product->id}}" title="Quick view"  rel="nofollow"><i class="fa fa-search"></i></a></li>
                                <li><a href="{{route('vinograd.cabinet.wishlist.add', ['id' => $product->id])}}" title="Whishlist" rel="nofollow"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="#" data-product-id="{{$product->id}}" data-url="{{route('vinograd.compare.add')}}" title="В сравнение" data-action="add" class="compare"  rel="nofollow"><i class="fa fa-refresh"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
