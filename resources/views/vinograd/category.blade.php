@extends('layouts.vinograd-left')

@section('title')
    @if($category)
        {{$category->title}} - описание, фото, черенки и саженцы, купить в Минске, Беларусь.{{$page ? ' Страница - ' . $page : ''}}
    @else
        Черенки и саженцы винограда купить в Минске, Беларусь. Полный каталог сортов.{{$page ? ' Страница - ' . $page : ''}}
    @endif
@endsection
@section('key', $category ? $category->meta_key : 'виноград, черенки и саженцы, купить в Минске, Беларусь')
@section('desc')
    @if($category)
        {{$category->meta_desc}}{{$page ? ' Страница - ' . $page : ''}}
    @else
        Черенки и саженцы винограда купить в Минске, Беларусь. Полный каталог сортов.{{$page ? ' Страница - ' . $page : ''}}
    @endif
@endsection

@section('head')
    @if($category)
        <link rel="canonical" href="{{route('vinograd.category.' . $category->category_field, ['slug' => $category->slug])}}" />
    @else
        <link rel="canonical" href="{{route('vinograd.category')}}" />
    @endif
@endsection

@section('breadcrumb-content')
    @if($category)
        <li><a href="{{route('vinograd.category')}}">Каталог сортов винограда</a></li>
        @if($page)
        <li><a href="{{route('vinograd.category.' . $category->category_field, ['slug' => $category->slug])}}">{{$category->title}}</a></li>
        <li class="active">Страница - {{$page}}</li>
        @else
        <li class="active">{{$category->title}}</li>
        @endif
    @else
        <li class="active">Каталог сортов винограда</li>
    @endif
@endsection

@section('section-title')
    @include('components.section-title', ['title' => $category ? $category->title : 'Каталог сортов винограда', 'page' => $page])
@endsection

@section('left-content')

    <div class="shop-layout">
        <div class="shop-topbar-wrapper d-md-flex justify-content-md-between align-items-center">
            <div class="grid-list-option">
                <ul class="nav">
                    <li>
                        <span class="{{$grid_list == 'grid' ? 'active ' : ''}}grid-list grid"
                              data-grid-list="grid" data-url="{{route('vinograd.ajax.grid-list')}}"
                              data-category="{{$category ? $category->id : ''}}"
                              data-page="{{$page}}"
                              data-toggle="tooltip"
                              data-placement="top"
                              data-model="{{$category ? $category->category_field : ''}}"
                              title="Сетка"
                        >
                            <i class="fa fa-th-large"></i>
                        </span>
                    </li>
                    <li>
                        <span class="{{$grid_list == 'list' ? 'active ' : ''}}grid-list list"
                              data-grid-list="list"
                              data-url="{{route('vinograd.ajax.grid-list')}}"
                              data-category="{{$category ? $category->id : ''}}"
                              data-page="{{$page}}"
                              data-toggle="tooltip"
                              data-placement="top"
                              data-model="{{$category ? $category->category_field : ''}}"
                              title="Список"
                        >
                            <i class="fa fa-th-list"></i>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="toolbar-short-area d-md-flex align-items-center">
                <form action="?" method="GET">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Показать:</span>
                        </div>
                        {{Form::select('ripening_by',
                            $ripening,
                            request('ripening_by'),
                            [
                                'class' => 'custom-select',
                                'placeholder' => 'все сроки созревания'
                            ])
                        }}
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Сортировать по:</span>
                        </div>
                        {{Form::select('order_by',
                            $sort,
                            request('order_by'),
                            [
                                'class' => 'custom-select'
                            ])
                        }}
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                        </div>
                    </div>
{{--                <p class="show-product">Показано: {{$products->firstItem()}} - {{$products->lastItem()}} из {{$products->total()}} товаров</p>--}}
                </form>
            </div>
        </div>
        <div class="single-feature d-flex flex-row-reverse p-2">
            <div class="feature-content ml-3">
                <a href="https://www.youtube.com/channel/UC5-E2vxUNeMUqAYSDCFO23w" target="_blank" rel="nofollow">
                    <span class="fa-stack fa-lg text-success">
                      <i class="fa fa-circle-thin fa-stack-2x"></i>
                      <i class="fa fa-youtube fa-stack-1x text-danger"></i>
                    </span>
                    Наш YouTube канал
                </a>
            </div>

            <div class="feature-content ml-3">
                <a href="{{route('vinograd.page', ['slug' => 'nashi-cherenki'])}}">
                    <span class="fa-stack fa-lg text-success">
                      <i class="fa fa-circle-thin fa-stack-2x"></i>
                      <i class="fa fa-info fa-stack-1x"></i>
                    </span>
                    Такие черенки мы продаем
                </a>
            </div>
{{--            <div class="feature-content ml-3">--}}
{{--                <a href="#">--}}
{{--                    <span class="fa-stack fa-lg text-success">--}}
{{--                      <i class="fa fa-circle-thin fa-stack-2x"></i>--}}
{{--                      <i class="fa fa-info fa-stack-1x"></i>--}}
{{--                    </span>--}}
{{--                    Такие саженцы мы продаем--}}
{{--                </a>--}}
{{--            </div>--}}
        </div>
        @if(request('ripening_by'))
            <h2 class="mb-4 mt-4 text-center">Показаны сорта: {{\App\Models\Vinograd\Category::getRipeningName(request('ripening_by'))}} - дней вегетации</h2>
        @endif
        <div class="shop-product">

            <div class="alert alert-primary mt-3 mb-3" role="alert">
                <h3 class="alert-heading">Внимание, ассортимент еще будет расширяться!</h3>
{{--                <p>Будет происходить обновление ассортимента</p>--}}
            </div>

            <div id="grid">

                @include('vinograd.components.product-'. $grid_list .'-view', ['products' => $products])

            </div>
            <div class="product-pagination">
                {{$products->links('components.pagination', ['param' => $param])}}
            </div>
        </div>
    </div>

@endsection

@section('category-content')

    <div class="about-us-area-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-us-content-2">
                        @if($category)
                        {!! $category->content !!}
                        @else
                        <h2>Черенки и саженцы винограда купить в Минске, Беларусь</h2>
                        <h2>Полный каталог сортов</h2>

                        <p>В настоящее время насчитывается более 20 тыс. культурных сортов винограда.</p>

                        <p>Каждый сорт имеет свой характерные свойства и признаки, унаследованные от родителей и связанные с местом происхождения.</p>

                        <p>По характеру использования сорта винограда делят на столовые, технические и универсальные.</p>

                        <p>К первой группе относят сорта, используемые для потребления в свежем виде. Плоды таких сортов имеют более нарядный внешний вид, крупные грозди и ягоды и отличаются высокими вкусовыми достоинствами.</p>

                        <p>Во вторую группу входят сорта, применяемые в основном для технической переработки.</p>

                        <p>Третью группу составляют сорта, которые могут использоваться как для потребления в свежем виде, так и для технических целей. В любительском виноградарстве наибольший интерес представляют столовые и универсальные сорта.</p>

                        <h3>Приблизительная группировка сортов винограда по срокам созревания<br>
                        <small>Может пригодиться при выборе сорта для посадки на своем участке</small>
                        </h3>
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Группа сортов</th>
                                    <th scope="col">Срок созревания, дней</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">Сверхранние</th>
                                    <td>
                                        <strong>90 – 100</strong><br>
                                        В средней полосе Беларуси созревают в первой половине августа
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Очень ранние</th>
                                    <td>
                                        <strong>100 – 110</strong><br>
                                        В средней полосе Беларуси созревают к концу августа
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Ранние</th>
                                    <td>
                                        <strong>110 – 120</strong><br>
                                        В средней полосе Беларуси созревают в первой половине сентября
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Ранне-средние</th>
                                    <td>
                                        <strong>120 - 130</strong><br>
                                        В средней полосе Беларуси для успешного выращивания ранне-средних сортов винограда необходимо создать благоприятные условия, это посадка у южных стен зданий или заборов, в идеальном случае выращивать эти сорта нужно в теплице.
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Средние</th>
                                    <td>
                                        <strong>130 - и более</strong><br>
                                        В средней полосе Беларуси сорта винограда среднего и более поздних сроков созревания в открытом грунте выращивать нецелесообразно, их необходимо выращивать в закрытой теплице. Еще более поздние сорта винограда требуют теплицу с искуственным подогревом и дополнительным освещением.
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <h4>
                                Перечисленные выше сроки довольно условные и даны в усредненном варианте для ознакомления.<br>
                                На срок созревания винограда оказывают влияние многочисленные факторы: место высадки на участке, погодные условия, тип почвы, наличие рядом водоемов, рек, лесов, сельхоз-полей, агроприемы при выращивании и еще множество факторов.
                            </h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
