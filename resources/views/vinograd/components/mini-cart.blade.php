@if($cart->getAmount())
    <a href="{{route('vinograd.cart.ingex')}}" rel="nofollow">
        <span class="cart-icon d-none d-xl-block">
{{--        <span class="cart-icon d-lg-none d-xl-block">--}}
           <span class="cart-quantity">{{$cart->getAmount()}}</span>
        </span>
        <span class="cart-title d-none d-xl-block">Ваша корзина <br><strong>{{currency($cart->getCost()->getTotal())}} {{signature()}}</strong></span>
{{--        <span class="cart-title d-lg-none d-xl-block">Ваша корзина <br><strong>{{currency($cart->getCost()->getTotal())}} {{signature()}}</strong></span>--}}
        <div class="wishlist-quantity-box d-xl-none">
{{--        <div class="wishlist-quantity-box d-none d-lg-block d-xl-none">--}}
            <i class="fa fa-shopping-cart" style="font-size: 18px;">
                <span class="cart-quantity">{{$cart->getAmount()}}</span>
            </i>
        </div>
    </a>
    <div class="cart-dropdown" style="display: none;">
        <ul>
            @foreach($cart->getItems() as $item)
                @php
                    $product = $item->getProduct();
                    $modification = $item->getModification();
                @endphp
            <li class="single-cart-item">
                <div class="cart-img">
                    <a href="{{route('vinograd.product', ['slug' => $product->slug])}}"><img src="{{asset($product->getImage('100x100'))}}"></a>
                </div>
                <div class="cart-content">
                    <h5 class="product-name"><a href="{{route('vinograd.product', ['slug' => $product->slug])}}">{{$product->name}}</a></h5>
                    <span class="cart-price"><strong>{{$modification->property->name}}</strong><br>{{$item->getQuantity()}} × {{currency($item->getPrice())}} {{signature()}}</span>
                </div>
                <div class="cart-remove">
                    {{Form::open(['route'=>['vinograd.cart.remove'], 'data-action' => 'remove-from-cart'])}}
                    {{Form::hidden('id', $item->getId())}}
                    {{Form::button('<i class="fa fa-times"></i>', [
                        'type' => 'submit',
                        'class' => "btn btn-link btn-sm",
                        'title' => 'Удалить'
                    ])}}
                    {{Form::close()}}
                </div>
            </li>
            @endforeach
        </ul>
        <p class="cart-subtotal"><strong>Стоимость:</strong> <span class="float-right">{{currency($cart->getCost()->getTotal())}} {{signature()}}</span></p>
        <p class="cart-btn">
            <a href="{{route('vinograd.cart.ingex')}}">Корзина</a>
            <a href="{{route('vinograd.checkout.delivery')}}">Оформить</a>
        </p>
    </div>

@endif
