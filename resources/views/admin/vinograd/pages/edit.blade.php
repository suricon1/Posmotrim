@extends('admin.layouts.layout')

@section('title', 'Admin | Редактировать страницу')
@section('key', 'Admin | Редактировать страницу')
@section('desc', 'Admin | Редактировать страницу')

@section('header-title', 'Редактировать страницу')

@section('content')

    <div class="col">
        {!! Form::open(['route' => ['pages.update', $page->id], 'method' => 'put']) !!}
        <div class="form-group">
            <label for="name">Название (В меню)</label>
            <input type="text" class="form-control" id="name" placeholder="" name="name" value="{{old('name', $page->name)}}">
        </div>
        <div class="form-group">
            <label for="slug">Алиас</label>
            <input type="text" class="form-control" id="slug" placeholder="" name="slug" value="{{old('slug', $page->slug)}}">
        </div>
        <div class="form-group">
            <label for="title">Заголовок (H1)</label>
            <input type="text" class="form-control" id="title" placeholder="" name="title" value="{{old('title', $page->title)}}">
        </div>
        <div class="form-group">
            <label for="text">Текст</label>
            <textarea name="content" id="content" class="form-control">{{old('content', $page->content)}}</textarea>
        </div>
        <div class="form-group">
            <label>
                {{Form::checkbox('status', '1', $page->status, ['class'=>'minimal'])}}
            </label>
            <label>
                Черновик
            </label>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="meta_key">Описание (description)</label>
                    <textarea name="meta_desc" class="form-control" rows="3" placeholder="Мета-описание ...">{{old('meta_desc', $page->meta_desc)}}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Ключевые слова (keywords)</label>
                    <textarea name="meta_key" class="form-control" rows="3" placeholder="Ключевые слова ...">{{old('meta_key', $page->meta_key)}}</textarea>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-success">Сохранить</button>
        </div>
        {!! Form::close() !!}
    </div>

@endsection

@section('scripts')
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script>
        var editor = CKEDITOR.replace('content');
    </script>
@endsection