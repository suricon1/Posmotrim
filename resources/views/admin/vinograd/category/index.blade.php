@extends('admin.layouts.layout')

@section('title', 'Admin | Список категорий виноградов')
@section('key', 'Admin | Список категорий виноградов')
@section('desc', 'Admin | Список категорий виноградов')

@section('header-title', 'Список категорий виноградов')

@section('content')

    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Назначение и тип</h3>
                <div class="card-tools">
                    <a href="{{route('categorys.create', ['model' => 'Category'])}}" class="btn btn-outline-success btn-xs"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Заголовок</th>
                        <th>Алиас</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categorys as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            <td>{{$category->title}}</td>
                            <td>{{$category->slug}}</td>
                            <td>
                                <div class="btn-group" id="nav">
                                    <a href="{{route('categorys.edit', ['id' => $category->id, 'model' => 'Category'])}}" class="btn btn-outline-success btn-sm"
                                       role="button"><i class="fa fa-pencil"></i></a>
                                    {{Form::open(['route'=>['categorys.destroy', $category->id], 'method'=>'delete'])}}
                                    {{Form::hidden('model', 'Category')}}
                                    <button onclick="return confirm('Подтвердите удаление страны!')" type="submit"
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
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Страна происхождения</h3>
                        <div class="card-tools">
                            <a href="{{route('categorys.create', ['model' => 'Country'])}}" class="btn btn-outline-success btn-xs"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Заголовок</th>
                                <th>Алиас</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($countrys as $country)
                                <tr>
                                    <td>{{$country->name}}</td>
                                    <td>{{$country->title}}</td>
                                    <td>{{$country->slug}}</td>
                                    <td>
                                        <div class="btn-group" id="nav">
                                            <a href="{{route('categorys.edit', ['id' => $country->id, 'model' => 'Country'])}}" class="btn btn-outline-success btn-sm"
                                               role="button"><i class="fa fa-pencil"></i></a>
                                            {{Form::open(['route'=>['categorys.destroy', $country->id], 'method'=>'delete'])}}
                                            {{Form::hidden('model', 'Country')}}
                                            <button onclick="return confirm('Подтвердите удаление страны!')" type="submit"
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
            <div class="col-md-6">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Селекционер</h3>
                    <div class="card-tools">
                        <a href="{{route('categorys.create', ['model' => 'Selection'])}}" class="btn btn-outline-success btn-xs"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th>Заголовок</th>
                            <th>Алиас</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($selections as $selection)
                            <tr>
                                <td>{{$selection->name}}</td>
                                <td>{{$selection->title}}</td>
                                <td>{{$selection->slug}}</td>
                                <td>
                                    <div class="btn-group" id="nav">
                                        <a href="{{route('categorys.edit', ['id' => $selection->id, 'model' => 'Selection'])}}" class="btn btn-outline-success btn-sm"
                                           role="button"><i class="fa fa-pencil"></i></a>
                                        {{Form::open(['route'=>['categorys.destroy', $selection->id], 'method'=>'delete'])}}
                                        {{Form::hidden('model', 'Selection')}}
                                        <button onclick="return confirm('Подтвердите удаление страны!')" type="submit"
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
    </div>

@endsection
