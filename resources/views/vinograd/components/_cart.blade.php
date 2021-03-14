<div class="table-content table-responsive">
    <table class="table">
        <thead>
        <tr>

            <th class="plantmore-product-thumbnail"></th>
            <th class="cart-product-name">Наименование</th>
            <th class="plantmore-product-price">Цена за шт</th>
            <th class="plantmore-product-quantity">Кол-во</th>
            <th class="plantmore-product-subtotal">Сумма</th>
            <th class="plantmore-product-remove"></th>
        </tr>
        </thead>
        <tbody>

        @forelse($cart->getItems() as $item)
            @php
                $product = $item->getProduct();
                $modification = $item->getModification();
            @endphp
            <tr>

                <td class="plantmore-product-thumbnail"><a href="{{route('vinograd.product', ['slug' => $product->slug])}}"><img src="{{$product->getImage('100x100')}}" width="100"></a></td>
                <td class="plantmore-product-name"><a href="{{route('vinograd.product', ['slug' => $product->slug])}}"><strong>{{$product->name}}</strong></a><br>{{$modification->property->name}}</td>
                <td class="plantmore-product-price"><span class="amount">{{currency($item->getPrice())}} {{signature()}}</span></td>
                <td class="plantmore-product-quantity">
                    {{Form::open(['route'=>['vinograd.cart.quantity'], 'data-action' => 'update-cart'])}}
                    <div class="d-flex flex-row">
                        <span class="input-group-text">шт</span>
                        {{Form::number('quantity', $item->getQuantity())}}
                        <button class="btn btn-outline-secondary"><i class="fa fa-refresh"></i></button>
                        {{Form::hidden('id', $item->getId())}}
                    </div>
                    {{Form::close()}}
                </td>
                <td class="product-subtotal"><span class="amount">{{currency($item->getCost())}} {{signature()}}</span></td>
                <td class="plantmore-product-remove">
                    {{Form::open(['route'=>['vinograd.cart.remove'], 'data-action' => 'remove-from-cart'])}}
                    {{Form::hidden('id', $item->getId())}}
                    {{Form::button('<i class="fa fa-times"></i>', [
                        'type' => 'submit',
                        'class' => "btn btn-link btn-sm",
                        'title' => 'Удалить'
                    ])}}
                    {{Form::close()}}
                </td>
            </tr>
        @empty
            <tr><td colspan="6"><h3>У Вас в корзине ничего нет!</h3></td></tr>
        @endforelse

        </tbody>
    </table>
</div>
{{--    <div class="row">--}}
{{--        <div class="col-12">--}}
{{--            <div class="coupon-all">--}}
{{--                <div class="coupon">--}}
{{--                    <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Coupon code" type="text">--}}
{{--                    <input class="button" name="apply_coupon" value="Apply coupon" type="submit">--}}
{{--                </div>--}}
{{--                <div class="coupon2">--}}
{{--                    <input class="button" name="update_cart" value="Пересчитать корзину" type="submit">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

@php
    $cost = $cart->getCost()
@endphp
<div class="row">
    <div class="col-md-5 ml-auto">
        <div class="cart-page-total">
            <h2>Итоговая стоимость</h2>
            <ul>
                <li>Полная стоимость <span>{{currency($cost->getOrigin())}} {{signature()}}</span></li>

                @foreach ($cost->getDiscounts() as $discount)
                    <tr>
                        <td class="text-right"><strong>{{$discount->getName()}}</strong></td>
                        <td class="text-right">{{$discount->getValue()}}</td>
                    </tr>
                @endforeach

                <li>К оплате <span>{{currency($cost->getTotal())}} {{signature()}}</span></li>
            </ul>
            <a href="{{route('vinograd.checkout.delivery')}}">Оформить покупку</a>
        </div>
    </div>
</div>
