@extends('admin.layouts.layout')

@section('title', 'Admin | Добавить метод доставки')
@section('key', 'Admin | Добавить метод доставки')
@section('desc', 'Admin | Добавить метод доставки')

@section('header-title', 'Добавить метод доставки')

@section('content')

    <div class="col">
        {!! Form::open(['route' => 'deliverys.store']) !!}
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" class="form-control" id="name" placeholder="" name="name" value="{{old('name')}}">
        </div>
        <div class="form-group">
            <label for="slug">Алиас</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug')}}">
        </div>
        <div class="form-group">
            <label for="text">Текст</label>
            <textarea name="content" id="content" class="form-control">{{old('content')}}</textarea>
        </div>
        <br><hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cost">Минимальная стоимость доставки посылки (за отправку посылки, вес которой не превышает Min-массу)</label>
                    <input type="number" class="form-control" id="cost" name="cost" value="{{old('cost')}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cost">Почтовый тариф (за каждые 100гр. свыше Min-массы)</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{old('price')}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="min_weight">Min-масса (до этого веса посылки отправляются за минимальную стоимость)</label>
                    <input type="text" class="form-control" id="min_weight" name="min_weight" value="{{old('min_weight')}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="max_weight">Масса-max (пока не задействована)</label>
                    <input type="text" class="form-control" id="max_weight" name="max_weight" value="{{old('max_weight')}}">
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-success">Добавить</button>
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
