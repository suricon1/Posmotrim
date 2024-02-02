@extends('admin.layouts.layout')

@section('title', 'Admin | Список постов')
@section('key', 'Admin | Список постов')
@section('desc', 'Admin | Список постов')

@section('header-title', 'Список постов')

@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <a href="{{route('blog.posts.create')}}" class="btn btn-success">Добавить новую статью</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Алиас</th>
                            <th>Просмотры</th>
                            <th>Картинка</th>
                            <th>Действия</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($posts as $post)
                            <tr>
                                <td>{{$post->id}}</td>
                                <td>{{$post->name}}</td>
                                <td>{{$post->slug}}</td>
                                <td>{{$post->view}}</td>
                                <td>
                                @if($post->getImage())
                                    <img src="{{asset($post->getImage('220x165'))}}" alt="" width="100">
                                @endif
                                </td>
                                <td>
                                    <div class="btn-group" id="nav">
                                        @if($post->status == 1)
                                            <a class="btn btn-outline-warning btn-sm" href="{{route('blog.posts.toggle', ['id' => $post->id])}}" role="button"><i class="fa fa-lock"></i></a>
                                        @else
                                            <a class="btn btn-outline-success btn-sm" href="{{route('blog.posts.toggle', ['id' => $post->id])}}" role="button"><i class="fa fa-thumbs-o-up"></i></a>
                                        @endif
                                        <a class="btn btn-outline-primary btn-sm" href="{{route('blog.posts.edit', $post)}}" role="button"><i class="fa fa-pencil"></i></a>
                                        @if($post->status != 1)
                                            <a class="btn btn-outline-secondary btn-sm" href="{{route('blog.post', ['slug' => $post->slug])}}" role="button" target="_blank">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
                                        {{Form::open(['route'=>['blog.posts.destroy', $post->id], 'method'=>'delete'])}}
                                        <button onclick="return confirm('Подтвердите удаление Статьи!')" type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-remove"></i></button>
                                        {{Form::close()}}
                                    </div>
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                {{$posts->links()}}
            </div>
        </div>
    </div>

@endsection
