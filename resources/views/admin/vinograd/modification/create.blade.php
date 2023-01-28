@extends('admin.layouts.layout')

@section('title', 'Admin | Добавить модификацию')
@section('key', 'Admin | Добавить модификацию')
@section('desc', 'Admin | Добавить модификацию')

@section('header-title', 'Добавить модификацию')

@section('content')

    <div class="col">
        {!! Form::open(['route' => 'modifications.store']) !!}
        <div class="form-group">
            <label for="name">Название (В меню)</label>
            <input type="text" class="form-control" id="name" placeholder="" name="name" value="{{old('name')}}">
        </div>
        <div class="form-group">
            <label for="slug">Вес</label>
            <input type="number" class="form-control" id="weight" placeholder="" name="weight" value="{{old('weight')}}">
        </div>
        <div class="box-footer">
            <button class="btn btn-success">Сохранить</button>
        </div>
        {!! Form::close() !!}
    </div>

@endsection
