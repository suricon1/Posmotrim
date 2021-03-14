@extends('admin.layouts.layout')

@section('title', 'Admin | Каталог сортов винограда')
@section('key', 'Admin | Каталог сортов винограда')
@section('desc', 'Admin | Каталог сортов винограда')

@section('header-title', 'Каталог сортов винограда')

@section('header')
    <link rel="stylesheet" href="/css/dataTables.bootstrap4.css">
@endsection

@section('content')

<div class="col">
    <div class="card">
        <div class="card-header">
            <div class="form-group">
                <a href="{{route('products.create')}}" class="btn btn-success">Добавить виноград</a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Алиас</th>
                    <th>Цены и количество</th>
                    <th>Картинка</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->getCategory()}}</td>
                        <td>{{$product->slug}}</td>
                        <td>
                            @foreach($product->adminModifications as $modification)
                                @include('admin.vinograd.product._modification-input-item', ['modification' => $modification])
                            @endforeach
                        </td>
                        <td><img src="{{asset($product->getImage('100x100'))}}" alt="" width="100"></td>
                        <td>
                            <div class="btn-group" id="nav">
                                @if($product->status == 1)
                                    <a class="btn btn-outline-warning btn-sm" href="{{route('products.toggle', ['id' => $product->id])}}" role="button"><i class="fa fa-lock"></i></a>
                                @else
                                    <a class="btn btn-outline-success btn-sm" href="{{route('products.toggle', ['id' => $product->id])}}" role="button"><i class="fa fa-thumbs-o-up"></i></a>
                                @endif
                                <a class="btn btn-outline-primary btn-sm" href="{{route('products.edit', $product->id)}}" role="button"><i class="fa fa-pencil"></i></a>
                                @if($product->status != 1)
                                    <a class="btn btn-outline-secondary btn-sm" href="{{route('vinograd.product', ['alias' => $product->slug])}}" role="button" target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endif
                                {{Form::open(['route'=>['products.destroy', $product->id], 'method'=>'delete'])}}
                                <button onclick="return confirm('Подтвердите удаление Статьи!')" type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-remove"></i></button>
                                {{Form::close()}}
                            </div>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>

@endsection

@section('scripts')

    <script src="/js/jquery.dataTables.js"></script>
    <script src="/js/dataTables.bootstrap4.js"></script>
    <script src="/js/multiUploadViewt.js" ></script>

    <script>
        $(function () {
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": false,
                "stateSave": true,
                "aaSorting": [[ 1, "asc" ]],
                "iDisplayLength": 20,
                "aLengthMenu": [[ 10, 20, 50, 100 ,-1],[10,20,50,100,"все"]],

                //"autoWidth": false,
                "language": {
                    "processing": "Подождите...",
                    "search": "Поиск:",
                    "lengthMenu": "Показывать по  _MENU_  записей",
                    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                    "infoEmpty": "Записи с 0 до 0 из 0 записей",
                    "infoFiltered": "(отфильтровано из _MAX_ записей)",
                    "infoPostFix": "",
                    "loadingRecords": "Загрузка записей...",
                    "zeroRecords": "Записи отсутствуют.",
                    "emptyTable": "В таблице отсутствуют данные",
                    "paginate": {
                        "first": "Первая",
                        "previous": "Предыдущая",
                        "next": "Следующая",
                        "last": "Последняя"
                    },
                },
                "columnDefs": [ //  Исключаем из поиска столбца Алиас Картинка и Действия
                    {
                        "targets": [ 3 ],
                        "searchable": false
                    },
                    {
                        "targets": [ 4 ],
                        "searchable": false
                    },
                    {
                        "targets": [ 5 ],
                        "searchable": false
                    }
                ]
            });
        });
    </script>

@endsection
