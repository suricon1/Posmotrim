@extends('admin.layouts.layout')

@section('title', 'Admin | Редактировать метод доставки')
@section('key', 'Admin | Редактировать метод доставки')
@section('desc', 'Admin | Редактировать метод доставки')

@section('header-title', 'Редактировать метод доставки')

@section('content')

    <div class="col">
        {!! Form::open(['route' => ['deliverys.update', $delivery->id], 'method' => 'put']) !!}
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" class="form-control" id="name" placeholder="" name="name" value="{{old('name', $delivery->name)}}">
        </div>
        <div class="form-group">
            <label for="text">Текст</label>
            <textarea name="content" id="content" class="form-control">{{old('content', $delivery->content)}}</textarea>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cost">Стоимость</label>
                    <input type="number" class="form-control" id="cost" name="cost" value="{{old('cost', $delivery->cost)}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="slug">Алиас</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug', $delivery->slug)}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="min_weight">Масса-min</label>
                    <input type="text" class="form-control" id="min_weight" name="min_weight" value="{{old('min_weight', $delivery->min_weight)}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="max_weight">Масса-max</label>
                    <input type="text" class="form-control" id="max_weight" name="max_weight" value="{{old('max_weight', $delivery->max_weight)}}">
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
