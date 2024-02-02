@extends('admin.layouts.layout')

@section('title', 'Admin | Редактировать модификацию - ' . $modification->name)
@section('key', 'Admin | Редактировать модификацию')
@section('desc', 'Admin | Редактировать модификацию')

@section('header-title', 'Редактировать модификацию - ' . $modification->name)

@section('content')

    <div class="col">
        {!! Form::open(['route' => ['modifications.update', $modification->id], 'method' => 'patch']) !!}
        <div class="form-group">
            <label for="name">Название (В меню)</label>
            <input type="text" class="form-control" id="name" placeholder="" name="name" value="{{old('name', $modification->name)}}">
        </div>
        <div class="form-group">
            <label for="slug">Вес</label>
            <input type="number" class="form-control" id="weight" placeholder="" name="weight" value="{{old('weight', $modification->weight)}}">
        </div>
        <div class="box-footer">
            <button class="btn btn-success">Сохранить</button>
        </div>
        {!! Form::close() !!}
    </div>

@endsection
