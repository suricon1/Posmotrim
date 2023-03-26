@extends('layouts.vinograd-left')

@section('title', 'Прайс лист, купить черенки и саженцы винограда, Минск, Беларусь')
@section('key', 'Прайс лист, черенки и саженцы винограда')
@section('desc', 'Черенки и саженцы винограда, купить в Минске, Беларусь. Полный прайс лист.')

@section('breadcrumb-content')
    <li class="active">Прайс лист</li>
@endsection

@section('section-title')
    @include('components.section-title', ['title' => 'Прайс лист', 'page' => ''])
@endsection

@section('left-content')


{{--    <div class="alert alert-warning" role="alert">--}}
{{--        По техническим причинам <strong>корзина</strong> временно не работает. По всем вопросам обращайтесь на Email сайта: <a href="mailto:{{config('main.admin_email')}}?subject=Вопрос по винограду"><u>{{config('main.admin_email')}}</u></a>, или в <a href="{{route('vinograd.contactForm')}}"><u>форму обратной связи</u></a>.--}}
{{--    </div>--}}

    <div class="wishlist-area mb-110">

{{--        <div class="alert alert-primary mt-3 mb-3" role="alert">--}}
{{--            <h3 class="alert-heading">Внимание, ассортимент еще будет расширяться!</h3>--}}
{{--            <p>Обновление ассортимента будет происходить по мере укоренения черенков</p>--}}
{{--        </div>--}}


        <h4 class="mb-4 mt-4"><i class="fa fa-asterisk text-danger"></i>
            Если в поле Стоимость пусто, значит ни черенков ни саженцев этого сорта нет в наличии.
        </h4>
        <div class="table-content table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th class="plantmore-product-remove">Название</th>
                    <th class="plantmore-product-thumbnail">Созревает<br>(дней)</th>
                    <th class="cart-product-name">Вес грозди<br>(гр)</th>
                    <th class="plantmore-product-price">Окраска</th>
                    <th class="plantmore-product-stock-status">Вкус</th>
                    <th class="plantmore-product-add-cart"> Стоимость<br>({{signature()}})</th>
                </tr>
                </thead>
                <tbody>

                @foreach($categorys as $category)
                    <tr>
                        <td colspan="6"><h3>{{$category->name}}</h3></td>
                    </tr>

                    @foreach ($category->productsActive as $product)
                        <tr>
                            <td class="plantmore-product-name">
                                <a href="#" class="open-modal" data-product-id="{{$product->id}}" title="Быстрый просмотр" rel="nofollow">{{ $product->name }}</a>
                                @if($product->selection->id != 1)
                                <br><small>({{$product->selection->name}})</small>
                                @endif
                            </td>
                            <td>{{$category::getRipeningDays($product->ripening)}}</td>
                            <td>{{ $product->props['mass'] }}</td>
                            <td>{{ $product->props['color'] }}</td>
                            <td>{{ $product->props['flavor'] }}</td>
                            <td>
                                @forelse($product->modifications as $modification)
                                    {{$modification->property->name}} - <strong>{{currency($modification->price)}}</strong><br>
                                @empty
                                @endforelse
                            </td>
                        </tr>
                    @endforeach

                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection
