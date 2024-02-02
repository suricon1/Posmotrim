@extends('admin.layouts.layout')

@section('title', 'Admin - Блог | Редактировать комментарий')
@section('key', 'Admin - Блог | Редактировать комментарий')
@section('desc', 'Admin - Блог | Редактировать комментарий')

@section('header-title', 'Редактировать комментарий')

@section('content')

    <div class="col">
        {!! Form::open(['route' => ['blog.comments.update', $comment->id], 'method' => 'patch']) !!}
        <div class="form-group">
            <label for="text">Текст</label>
            <textarea name="text" id="text" class="form-control">{{$comment->text}}</textarea>
        </div>
        <div class="box-footer">
            <button class="btn btn-success">Обновить</button>
        </div>
        {!! Form::close() !!}
    </div>

@endsection

@section('scripts')
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script>
        var editor = CKEDITOR.replace('text');
    </script>
@endsection
