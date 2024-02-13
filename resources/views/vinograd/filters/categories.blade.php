<ul>
    <li><a href="{{route('vinograd.category')}}">Все сорта</a></li>

    @foreach($filter->values() as $item)
        <li>
            <a href="{{route('vinograd.category.' . $filter->key(), ['slug' => $item['slug']])}}">{{$item['name']}}</a>
            <span class="count">({{$item['count']}})</span>
        </li>
    @endforeach
</ul>

