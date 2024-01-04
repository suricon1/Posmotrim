@extends('layouts.vinograd-left')

@section('title', isset($category) ? $category->title : config('app.name').'. Вырашивание винограда в Беларуси, виноделие в Беларуси.' . $page)
@section('key', isset($category) ? $category->title : config('app.name').', вырашивание винограда, виноделие, Беларусь')
@section('desc', isset($category) ? $category->title : config('app.name').' - Статьи о вырашивании винограда и виноделии в Беларуси.' . $page)

@section('head')
    <link rel="canonical" href="{{route('blog.home')}}" />
@endsection

@section('breadcrumb-content')
    @if(isset($category))
        <li><a href="{{route('blog.home')}}">Блог</a></li>
        <li class="active">{{$category->title}}</li>
    @else
        <li class="active">Блог</li>
    @endif

@endsection

@section('section-title')
    @include('components.section-title', ['title' => isset($category) ? $category->title : 'Виноградарство Беларуси'])
@endsection

@section('left-content')

    <div class="shop-topbar-wrapper">
        <form action="?" method="GET">
            <div class="toolbar-short-area row">
                <div class="input-group col-md-8">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">Сортировать по:</span>
                    </div>
                    {{Form::select('field',
                        [
                            'date_add' => 'Дате публикации',
                            'name'    => 'Названию',
                            'view' => 'Популярности'
                        ],
                        request('field'),
                        [
                            'class' => 'custom-select'
                        ])
                    }}
                    {{Form::select('order_by',
                        [
                            'desc' => 'По убыванию',
                            'asc' => 'По возрастанию'
                        ],
                        request('order_by'),
                        [
                            'class' => 'custom-select'
                        ])
                    }}
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Показать</button>
{{--                        <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-refresh" aria-hidden="true"></i></button>--}}
                    </div>
                </div>
                <div class="show-product col-md-4 text-right">Показаны: {{$posts->firstItem()}} - {{$posts->lastItem()}} из {{$posts->total()}} статей</div>
            </div>
        </form>
    </div>
    <div class="blog_area">
        <div class="row">
            @foreach($posts as $post)
            <div class="col-md-6">

                <article class="blog_single">
                    <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="{{route('blog.post', ['slug' => $post->slug])}}">{{ $post->name }}</a>
                        </h2>
                    </header>
                    <div class="post-thumbnail img-full">
{{--                        @if($post->getImage())--}}
                        <a href="{{route('blog.post', ['slug' => $post->slug])}}">
                            <img src="{{ asset($post->getImage('660x495')) }}" alt="{{ $post->name }}">
                        </a>
{{--                        @endif--}}
                        <div class="post-info-bloc">
                            <div class="post-date">
                                <div class="date">{{ getRusDate($post->date_add, 'd %MONTH% Y') }}</div>
                            </div>
                            <div class="post-comments-count">
                                <i class="fa fa-eye"></i> {{$post->view}}
                                <a href="{{ route('blog.post', ['slug' => $post->slug]) }}#comments" title="Открыть комментарии">
                                    <i class="fa fa-comments-o"></i>{{$post->comments->count()}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="postinfo-wrapper">
                        <div class="post-info">
                            <div class="entry-summary">
                                @if($post->description)
                                    {!! $post->description !!}
                                @else
                                    <p>{{ $post->StrLimit($post->content, 400) }}</p>
                                @endif
                                <a href="{{route('blog.post', ['slug' => $post->slug])}}" class="form-button">Читать статью</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            @if($loop->iteration % 2 == 0)
            <div class="w-100"></div>
            @endif

            @if($loop->iteration % 4 == 0)
                    <div class="col-md-12">
                        @include('components.reklama.google_blog_post_text')
                    </div>
{{--                    <div class="col-md-6">--}}
{{--                        @include('components.reklama.google_index_bottom_1')--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        @include('components.reklama.google_index_bottom_2')--}}
{{--                    </div>--}}
            @endif

            @endforeach
        </div>
    </div>

    <div class="product-pagination">
        {{$posts->links('components.pagination', ['param' => $param])}}
    </div>

@endsection

@section('category-content')
    <div class="about-us-area-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-us-content-2">
                        @if(isset($category))
                            {!! $category->content !!}
                        @else
                        <h2>Любительское виноградарство — интересное, увлекательное и очень полезное занятие.</h2>

                        <p>Любительское виноградарство способствует сохранению старейших способов культуры, форм и систем выведения кустов. На приусадебных участках можно выращивать более нежные сорта, получать зрелый виноград в самые ранние сроки и лучшего качества.</p>

                        <p>Условия выращивания винограда на приусадебных участках резко отличаются от промышленных. Как правило, на участках выращивают сорта винограда, имеющие различную зимостойкость, сроки созревания, устойчивость к болезням. При этом кусты винограда произрастают в соседстве с плодовыми, овощными, цветочными и другими культурами.</p>

                        <p>Все работы на любительском винограднике в основном проводят вручную. Близость жилых помещений требует особой осторожности при использовании пестицидов, гербицидов, удобрений.</p>

                        <p>В этом разделе сайта Вы узнаете основные свойствама и особенности виноградного растения, какие нужны условия для продуктивного произрастания кустов, простым и доступным языком мы расскажем о приемах агротехники при выращивании винограда на садовых участках, а также по защите растений от морозов, заморозков, болезней и вредителей.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
