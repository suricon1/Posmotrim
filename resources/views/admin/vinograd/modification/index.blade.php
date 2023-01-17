@extends('admin.layouts.layout')

@section('title', 'Admin | Список модификаций')
@section('key', 'Admin | Список модификаций')
@section('desc', 'Admin | Список модификаций')

@section('header-title', 'Список модификаций')

@section('content')

    <div class="col">
        <div class="card">
            <div class="card-header">
                <a href="{{route('modifications.create')}}" class="btn btn-success">Добавить модификацию</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Название</th>
                            <th>Вес (гр.)</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($modifications as $modification)
                        <tr>
                            <td>{{$modification->id}}.</td>
                            <td>{{$modification->name}}</td>
                            <td>{{$modification->weight}}</td>
                            <td><div class="btn-group" id="nav">
                                    <a href="{{route('modifications.edit', $modification->id)}}" class="btn btn-outline-primary btn-sm"
                                       role="button"><i class="fa fa-pencil"></i></a>
                                    {{Form::open(['route'=>['modifications.destroy', $modification->id], 'method'=>'delete'])}}
                                    <button onclick="return confirm('Подтвердите удаление модификации!')" type="submit"
                                            class="btn btn-outline-danger btn-sm"><i class="fa fa-remove"></i></button>
                                    {{Form::close()}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
