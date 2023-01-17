@foreach($categorys as $category)
    <tr>
        <td colspan="6"><h3>{{$category->name}}</h3></td>
    </tr>

    @foreach ($category->productsActive as $product)
        <tr>
            <td class="plantmore-product-name">
                {{--                            <a href="{{route('vinograd.product', ['slug' => $product->slug])}}">{{ $product->name }}</a>--}}
                <a href="#" class="open-modal" data-product-id="{{$product->id}}" title="Быстрый просмотр" rel="nofollow">{{ $product->name }}</a>
            </td>
            <td>{{$category::getRipeningDays($product->ripening)}}</td>
            <td>{{ $product->mass }}</td>
            <td>{{ $product->color }}</td>
            <td>{{ $product->flavor }}</td>
            <td>
                @forelse($product->modifications as $modification)
{{--                    {{$modification->name}} - <strong>{{$modification->price}}</strong><br>--}}
                    {{$modification->name}} - <strong>{{currency($modification->price)}}</strong><br>
                @empty
                @endforelse
            </td>
        </tr>
    @endforeach

@endforeach
