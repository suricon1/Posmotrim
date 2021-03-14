@extends('layouts.vinograd-left')

@section('title', 'Избранное')
@section('key', 'Избранное')
@section('desc', 'Избранное')

@section('head')
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('breadcrumb-content')
   <li class="active">Избранное</li>
@endsection

@section('left-content')

    <div class="table-content table-responsive">
        <table class="table">
            <tbody>

            @forelse($products as $product)
            <tr>
                <td class="plantmore-product-thumbnail">
                    <a href="{{route('vinograd.product', ['slug' => $product->slug])}}">
                        <img src="{{asset($product->getImage('100x100'))}}" width="100">
                    </a>
                </td>
                <td class="plantmore-product-name"><a href="{{route('vinograd.product', ['slug' => $product->slug])}}">{{$product->name}}</a></td>
                <td class="plantmore-product-price">
                    <ul class="list-group list-group-flush">
                        @forelse($product->modifications as $modification)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{$modification->property->name}}</span>
                                {{Form::open(['route'=>['vinograd.cart.add'], 'class' => 'add-quantity', 'data-action' => 'add-to-cart'])}}
                                        {{Form::hidden('product_id', $product->id)}}
                                        {{Form::hidden('modification_id', $modification->id)}}
                                    <div class="input-group">
                                        {{Form::number('quantity', 1, ['class' => 'form-control'])}}
                                        <div class="input-group-append" id="button-addon4">
                                            {{Form::button('', ['class' => 'product-btn', 'type' => 'submit'])}}
                                        </div>
                                    </div>
                                {{Form::close()}}
                            </li>
                        @empty
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                            {!! config('main.empty_text_info') !!}
                            </li>
                        @endforelse
                    </ul>
                </td>
                <td class="plantmore-product-remove">
                    {{Form::open(['route'=>['vinograd.cabinet.wishlist.delete']])}}
                    {{Form::hidden('product_id', $product->id)}}
                    {{Form::button('<i class="fa fa-remove"></i>', [
                        'onclick' =>"return confirm('Подтвердите удаление!')",
                        'type' => 'submit',
                        'class' => "btn btn-outline-danger btn-sm"
                    ])}}
                    {{Form::close()}}
                </td>
            </tr>
            @empty
                <tr><td colspan="6"><h3>У Вас в избранном ничего нет!</h3></td></tr>
            @endforelse

            </tbody>
        </table>
    </div>

@endsection
