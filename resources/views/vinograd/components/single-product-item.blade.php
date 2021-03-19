<div class="single-product mb-25">
    <div class="product-img img-full">
        <a href="{{route('vinograd.product', ['slug' => $product->slug])}}">
            <img src="{{asset($product->getImage('400x400'))}}" alt="{{$product->name}}">
        </a>
{{--        <span class="onsale">Sale!</span>--}}
        <div class="product-action">
            <ul>
                <li><a href="#" class="open-modal" data-product-id="{{$product->id}}" title="Быстрый просмотр" rel="nofollow"><i class="fa fa-search"></i></a></li>
                <li><a href="{{route('vinograd.cabinet.wishlist.add', ['id' => $product->id])}}" title="Отложить" rel="nofollow"><i class="fa fa-heart-o"></i></a></li>
                <li><a href="#" data-product-id="{{$product->id}}" data-url="{{route('vinograd.compare.add')}}" data-action="add" class="compare" title="В сравнение" rel="nofollow"><i class="fa fa-refresh"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="product-content">
        <h4><a href="{{route('vinograd.product', ['slug' => $product->slug])}}">{{$product->name}}</a></h4>
        <div class="product-price">
            <div class="price-box">

                @forelse($product->modifications as $modification)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span style="white-space: nowrap;"><strong>{{$modification->property->name}}</strong></span>
{{--                        <span style="white-space: nowrap;"><strong>{{$modification->name}}</strong> - {{currency($modification->price)}} {{signature()}}</span>--}}
                        <span style="white-space: nowrap;">- {{currency($modification->price)}} {{signature()}}</span>
{{--                        <span style="white-space: nowrap;">в наличии <strong>{{$modification->quantity}}</strong> шт</span>--}}
                    </li>
                @empty
                    {!! config('main.empty_text_info') !!}
                @endforelse
            </div>
            <div class="add-to-cart">
                @forelse($product->modifications as $modification)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><strong>{{$modification->property->name}}</strong></span>
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
                    {!! config('main.empty_text_info') !!}
                @endforelse

            </div>
        </div>
    </div>
</div>
