@extends('admin.layouts.layout')

@section('title', 'Admin | Методы доставки')
@section('key', 'Admin | Методы доставки')
@section('desc', 'Admin | Методы доставки')

@section('header-title', 'Методы доставки')

@section('content')
    <div class="col">
        <div class="form-group">
            <a href="{{route('deliverys.create')}}" class="btn btn-success">Добавить метод доставки</a>
        </div>

        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>Картинка</th>
                    <th>Название</th>
                    <th>Текст</th>
                    <th>slug</th>
                    <th>Действия</th>
                </tr>
                </thead>

                <tbody>

                @foreach($deliverys as $delivery)
                    <tr>
                        <td><img src="{{Storage::url('pics/img/'.$delivery->slug.'.jpg')}}" width="200px"></td>
                        <td>{{$delivery->name}}</td>
                        <td>{!! $delivery->content !!}</td>
                        <td>{{$delivery->slug}}</td>
                        <td>
                            <div class="btn-group" id="nav">
                                @if($delivery->status == 1)
                                    <a class="btn btn-outline-warning btn-sm" href="{{route('deliverys.toggle', ['id' => $delivery->id])}}" role="button"><i class="fa fa-lock"></i></a>
                                @else
                                    <a class="btn btn-outline-success btn-sm" href="{{route('deliverys.toggle', ['id' => $delivery->id])}}" role="button"><i class="fa fa-thumbs-o-up"></i></a>
                                @endif
                                <a class="btn btn-outline-primary btn-sm" href="{{route('deliverys.edit', $delivery->id)}}" role="button"><i class="fa fa-pencil"></i></a>
{{--                                {{Form::open(['route'=>['deliverys.destroy', $delivery->id], 'method'=>'delete'])}}--}}
{{--                                <button onclick="return confirm('Подтвердите удаление Статьи!')" type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-remove"></i></button>--}}
{{--                                {{Form::close()}}--}}
                            </div>
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection
