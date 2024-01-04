<div class="header-menu text-center">
    <nav style="display: block;">
        <ul class="main-menu">
            <li>
            @foreach($pages as $slug => $name)
                @if($loop->iteration != 1)<li>@endif
                <a href="{{route('vinograd.page', ['slug' => $slug])}}">{{$name}}</a>
                @if($loop->iteration != 1)</li>@endif

                @if($loop->iteration == 1)<ul class="dropdown">@endif
                @if($loop->last)</ul>@endif

            @endforeach
            </li>
            <li><a href="{{route('vinograd.category')}}">Каталог</a>
                <ul class="dropdown">

                    @foreach($categorys as $category)
                    <li><a href="{{route('vinograd.category.category', ['slug' => $category->slug])}}">{{$category->name}}</a></li>
                    @endforeach

                </ul>
            </li>
            <li>
                <a href="{{route('vinograd.price')}}">Прайс</a>
            </li>
            <li><a href="{{route('blog.home')}}">Блог</a>
                <ul class="dropdown">

                    @foreach($categorys_blog_menu as $slug => $name)
                        <li><a href="{{route('blog.category', ['slug' => $slug])}}">{{$name}}</a></li>
                    @endforeach

                </ul>
            </li>
        </ul>
    </nav>
</div>
