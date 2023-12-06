<div class="product-small_list-view">
    <div class="table-content table-responsive">
        <table class="table">
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="plantmore-product-thumbnail">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('vinograd.product', ['slug' => $product->slug])}}">
                                    <img src="{{asset($product->getImage('100x100'))}}" width="100">
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('vinograd.product', ['slug' => $product->slug])}}"><h4 class="mt-2">{{$product->name}}</h4></a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <ul class="list-group list-group-flush">
                            @forelse($product->modifications as $modification)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="mr-2">{{$modification->property->name}} - <strong>{{currency($modification->price)}} {{signature()}}</strong></span>
                                    {{Form::open(['route'=>['vinograd.cart.add'], 'class' => 'add-quantity', 'data-action' => 'add-to-cart'])}}
                                    {{Form::hidden('product_id', $product->id)}}
                                    {{Form::hidden('modification_id', $modification->id)}}
                                    {{Form::hidden('quantity', 1)}}
                                    <div class="input-group">

                                        <div class="input-group-append" id="button-addon4">
                                            {{Form::button('', ['class' => 'product-btn', 'type' => 'submit'])}}
                                        </div>
                                    </div>
                                    {{Form::close()}}
                                </li>
                            @empty
                                <li class="list-group-item d-flex justify-content-between align-items-center">
{{--                                    {!! config('main.empty_text_info') !!}--}}
                                    <span class="text-danger">Нет в наличии</span>
                                </li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
