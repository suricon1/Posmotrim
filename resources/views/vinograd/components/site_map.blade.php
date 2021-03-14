<div class="card mb-3">
    <div class="card-body text-info">
        <div class="blog_Archives__sidbar row">
            <ul class="col">
                <li><a href="{{route('vinograd.home')}}">Главная</a></li>
                <li><a href="{{route('vinograd.category')}}">Каталог сортов винограда</a></li>
                <li><a href="{{route('vinograd.contactForm')}}">Контакты</a></li>
            </ul>
            <ul class="col">
                @foreach($pages as $page)
                    <li><a href="{{route('vinograd.page', ['slug' => $page->slug])}}">{{$page->name}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header" style="font-size: 20px">
        <a href="{{route('vinograd.category')}}">Каталог сортов винограда</a>
    </div>
    @foreach($categorys as $category)
    <div class="card-body text-info">
        <h4 class="card-title" style="border-bottom: solid 1px #d8d8d8;padding-bottom: 7px;">
            <a href="{{route('vinograd.category.category', ['slug' => $category->slug])}}">{{$category->name}}</a>
        </h4>

        <div class="blog_Archives__sidbar row">
            @foreach ($category->productsActive->chunk(ceil($category->productsActive->count() / 4)) as $chunk)
                <ul class="col-md-3 col-sm-6">
                    @foreach ($chunk as $product)
                        <li><a href="{{route('vinograd.product', ['slug' => $product->slug])}}">{{ $product->name }}</a></li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
    <div class="card-footer text-muted" style="padding: 2px;"></div>
    @endforeach
</div>

<div class="card mb-3">
    <div class="card-header" style="font-size: 20px">
        <a href="{{route('blog.home')}}">Блог</a>
    </div>
    @foreach($blogCategorys as $category)
    <div class="card-body text-info">
        <h4 class="card-title" style="border-bottom: solid 1px #d8d8d8;padding-bottom: 7px;">
            <a href="{{route('blog.category', ['slug' => $category->slug])}}">{{$category->name}}</a>
        </h4>

        <div class="blog_Archives__sidbar row">
            @foreach ($category->postsActive->chunk(ceil($category->postsActive->count() / 4)) as $chunk)
                <ul class="col-md-3 col-sm-6">
                    @foreach ($chunk as $post)
                        <li> <a href="{{route('blog.post', ['slug' => $post->slug])}}">{{ $post->name }}</a></li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
    <div class="card-footer text-muted" style="padding: 2px;"></div>
    @endforeach
</div>
