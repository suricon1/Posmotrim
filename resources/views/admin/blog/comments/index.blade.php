@extends('admin.layouts.layout')

@section('title', 'Admin-Блог | Комментарии')
@section('key', 'Admin-Блог | Комментарии')
@section('desc', 'Admin-Блог | Комментарии')

@section('header-title', 'Комментарии')

@section('content')

    <div class="col">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Пост</th>
                <th>Текст</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($comments as $comment)
                <tr>
                    <td><a href="{{route('blog.post', ['slug' => $comment->post['slug']])}}">{{$comment->post['name']}}</a></td>
                    <td>{!! $comment->text !!}</td>
                    <td>
                        <div class="btn-group" id="nav">
                            @if($comment->status == 1)
                                <a class="btn btn-outline-warning btn-sm" href="{{route('vinograd.comments.toggle', ['id' => $comment->id])}}" role="button"><i class="fa fa-lock"></i></a>
                            @else
                                <a class="btn btn-outline-success btn-sm" href="{{route('vinograd.comments.toggle', ['id' => $comment->id])}}" role="button"><i class="fa fa-thumbs-o-up"></i></a>
                            @endif
                            <a href="{{route('blog.comments.edit', $comment)}}" class="btn btn-outline-primary btn-sm" role="button"><i class="fa fa-pencil"></i></a>
                            {{Form::open(['route'=>['vinograd.comments.destroy', $comment->id], 'method'=>'delete'])}}
                            <button onclick="return confirm('Подтвердите удаление комментария!')" type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-remove"></i></button>
                            {{Form::close()}}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$comments->links('admin.components.pagination')}}
    </div>

@endsection
