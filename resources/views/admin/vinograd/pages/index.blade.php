@extends('admin.layouts.layout')

@section('title', 'Admin | Список страниц')
@section('key', 'Admin | Список страниц')
@section('desc', 'Admin | Список страниц')

@section('header-title', 'Список страниц')

@section('content')

    <div class="col">
        <div class="form-group">
            <a href="{{route('pages.create')}}" class="btn btn-success">Добавить страницу</a>
        </div>
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Заголовок</th>
                    <th>Алиас</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $i=>$page)
                    <tr>
                        <td>{{$page->name}}</td>
                        <td>{{$page->title}}</td>
                        <td>{{$page->slug}}</td>
                        <td>
                            <div class="btn-group" id="nav">
                                @if($page->status == 1)
                                <a class="btn btn-outline-warning btn-sm" href="{{route('pages.toggle', ['id' => $page->id])}}" role="button"><i class="fa fa-lock"></i></a>
                                @else
                                <a class="btn btn-outline-success btn-sm" href="{{route('pages.toggle', ['id' => $page->id])}}" role="button"><i class="fa fa-thumbs-o-up"></i></a>
                                @endif
                                <a href="{{route('pages.edit', $page->id)}}" class="btn btn-outline-primary btn-sm" role="button"><i class="fa fa-pencil"></i></a>

                                @if($pages->has($i - 1))
                                <a href="{{route('pages.move.up', ['id' => $page->id])}}" class="btn btn-outline-secondary btn-sm" role="button"><i class="fa fa-arrow-up"></i></a>
                                @endif

                                @if($pages->has($i + 1))
                                <a href="{{route('pages.move.down', ['id' => $page->id])}}" class="btn btn-outline-secondary btn-sm" role="button"><i class="fa fa-arrow-down"></i></a>
                                @endif

                                {{Form::open(['route'=>['pages.destroy', $page->id], 'method'=>'delete'])}}
                                <button onclick="return confirm('Подтвердите удаление страницы!')" type="submit"
                                        class="btn btn-outline-danger btn-sm"><i class="fa fa-remove"></i></button>
                                {{Form::close()}}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{--{{$categorys->links('admin.components.pagination')}}--}}
    </div>

@endsection