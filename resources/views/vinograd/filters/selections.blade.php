<div class="shop-sidebar mt-5">
    <h3>{{$filter->title()}}</h3>
    <div class="categori-checkbox">
        <ul>
            @foreach($filter->values() as $item)
                <li>
                    <input class="cat_fil"
                           name="{{$filter->name($item['id'])}}"
                           type="checkbox"
                           value="{{$item['id']}}"
                           @checked($filter->requestValue($item['id']))
                    >
                    <a href="{{route('vinograd.category.' . $filter->key(), ['slug' => $item['slug']])}}">{{$item['name']}}</a>
                    <span class="count">({{$item['count']}})</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
