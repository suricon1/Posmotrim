@extends('admin.layouts.layout')

@section('title', 'Admin | Список заказов')
@section('key', 'Admin | Список заказов')
@section('desc', 'Admin | Список заказов')

@section('header-title', 'Список заказов')

@section('content')

    <div class="col">

        <div class="card card-default collapsed-card">
            <div class="card-header">
                <button type="button" class="btn btn-tool" data-widget="collapse">
                    <h3 class="card-title"><i class="fa fa-angle-right"></i>Поиск и сортировка</h3>
                </button>
            </div>
            <div class="card-body" style="display: none;">
                <form action="?" method="GET">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="formGroupExampleInput">№ Заказа</label>
                                <input type="text" class="form-control" id="formGroupExampleInput" name="id"
                                       value="{{ request('id') }}">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label for="inputGroupSelect1">Email</label>
                                <input type="text" class="form-control" id="inputGroupSelect1" name="email"
                                       value="{{ request('email') }}">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label for="inputGroupSelect1">Телефон</label>
                                <input type="text" class="form-control" id="inputGroupSelect1" name="phone"
                                       value="{{ request('phone') }}">
                            </div>
                            <div class="form-group float-right">
                                <button type="submit" class="btn btn-primary">Найти</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9">
                        <h4>Показать заказы:</h4>
                        <a href="{{route('orders.index')}}" class="btn btn-outline-dark btn-sm">Все</a>
                        @foreach(statusList() as $status => $name)
                            <a href="{{route('orders.index.status', ['status' => $status])}}" class="btn-sm btn btn-{{statusColor($status)}}">
                                {{$name}}
                                @if($quantity_orders[$status])
                                    <span class="badge badge-light">{{$quantity_orders[$status]}}</span>
                                @endif
                            </a>
{{--                            {{ Html::linkRoute('orders.index.status', $name, ['status' => $status], ['class' => 'btn-sm btn btn-' . statusColor($status)]) }}--}}
                        @endforeach
                    </div>
                    <div class="col-3">
                        <h4>Создать заказ:</h4>
                        <a href="{{route('orders.create')}}" class="btn btn-success btn-sm">Новый</a>
                        <a href="{{route('orders.pre.create')}}" class="btn btn-warning btn-sm">Предварительный</a>
                    </div>
                </div>

            </div>
            <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Доставка</th>
                        <th>Создан</th>
                        <th>Стоимость</th>
                        <th>Заказчик</th>
                        <th>Примечание</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)

                        <tr>
                            <td>
                                {{$order->id}}
                                @if($order->isCreatedByAdmin())
                                    <span class="fa fa-check text-danger"></span>
                                @endif
                            </td>
                            <td>{{$order->delivery['method_name']}}</td>
                            <td>{{getRusDate($order->created_at)}}</td>
                            <td>
                                {{$order->cost}} бел. руб
                                @if($order->currency !== 'BYN')
                                    <br>
                                    {{mailCurr($currency[$order->currency], $order->getTotalCost()) }} {{ $currency[$order->currency]->sign}}
                                @endif
                            </td>
                            <td>{{$order->customer['name']}}</td>
                            <td>{{$order->admin_note}}</td>
                            <td style="min-width: 200px">
                                @if($statusesList[$order->id])
                                {!! Form::open(['route' => 'orders.set_status', 'data-ajax-url' => route('orders.set_ajax_status'), 'data-name' => 'status']) !!}
                                {!! Form::hidden('order_id', $order->id) !!}
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        {!! $order->statusName($order->current_status) !!}
                                    </div>
                                    <select name="status" class="custom-select form-control" id="inputGroupSelect04">
                                        <option selected disabled hidden>Изменить</option>
                                        @foreach($statusesList[$order->id] as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-outline-info btn-flat" title="Обновить"><i class="fa fa-refresh"></i></button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                                @else
                                    {!! $order->statusName($order->current_status) !!}
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" id="nav">
                                    @if(!$order->isCompleted())
                                        @if($order->isPreliminsry())
                                        <a class="btn btn-outline-primary btn-sm" href="{{route('orders.pre.edit', $order->id)}}" role="button"><i class="fa fa-pencil"></i></a>
                                        @else
                                        <a class="btn btn-outline-primary btn-sm" href="{{route('orders.edit', $order->id)}}" role="button"><i class="fa fa-pencil"></i></a>
                                        @endif
                                    @endif
                                    <a class="btn btn-outline-secondary btn-sm" href="{{route('orders.show', $order->id)}}" role="button"><i class="fa fa-eye"></i></a>
                                    @if($order->isSent() && $order->isTrackCode())
                                        <a class="btn btn-outline-info btn-sm" href="{{config('main.tracking_post')}}{{$order->track_code}}" role="button" target="_blank"><i class="fa fa-truck"></i></a>
                                    @endif
                                    {{Form::open(['route'=>['orders.destroy', $order->id], 'method'=>'delete'])}}
                                    <button onclick="return confirm('Подтвердите удаление заказа!')" type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-remove"></i></button>
                                    {{Form::close()}}
                                </div>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$orders->links()}}
            </div>
        </div>

    </div>

@endsection

@section('scripts')
<script>
window.addEventListener('DOMContentLoaded', function() {

    const postData = async (form) => {
        let res = await fetch(form.getAttribute('data-ajax-url'), {
            method: "POST",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            body: new FormData(form)
        });
        return await res.json();
    };

    const forms = document.querySelectorAll('form[data-name=status]');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            postData(form)
            .then(data => {
                if(data.success) {

                    this.badge = e.target.querySelector('.input-group-prepend');
                    this.alert = document.querySelector('#Succes');

                    if(data.success.code_form) {
                        this.alert.innerHTML = data.success.code_form;
                        //$("#Succes").html(data.success.code_form);
                        $('#SuccesModal').modal('show');

                        let code_form = this.alert.querySelector('form');
                        code_form.addEventListener('submit', (e) => {
                            e.preventDefault();

                            postData(code_form)
                                .then (data => {
                                    if(data.success) {
                                        this.badge.innerHTML = data.success;
                                        this.alert.innerHTML = 'Статус изменен.';
                                    } else if(data.errors){
                                        if (this.alert.querySelector(".errors") !== null) {
                                            this.alert.querySelector(".errors").innerHTML = get_list(data.errors);
                                        } else {
                                            const newEl = document.createElement("div");
                                            newEl.classList.add('alert', 'alert-danger', 'errors');
                                            newEl.innerHTML = get_list(data.errors);
                                            this.alert.querySelector(".card-header").replaceWith(newEl);
                                        }
                                    }else{
                                        console.log(data);
                                        const newEl = document.createElement("div");
                                        newEl.classList.add('alert', 'alert-danger', 'errors');
                                        newEl.innerHTML = 'Неизвестная ошибка. Повторите попытку, пожалуйста!';
                                        this.alert.replaceWith(newEl);
                                    }
                                })
                                .catch((error) => {
                                    console.log(error);
                                })
                                .finally(() => {
                                    //
                                });
                        });
                    } else {
                        this.badge.innerHTML = data.success.status;
                        this.alert.innerHTML = 'Статус изменен.';
                        // $("#Succes").html('Статус изменен.');
                        $('#SuccesModal').modal('show')
                    }
                }else if(data.errors){
                    errors_list(data.errors);
                }else{
                    console.log(data);
                    errors_list('Неизвестная ошибка. Повторите попытку, пожалуйста!');
                }
            }).catch((error) => {
                console.log(error);
            }).finally(() => {
                //
            });
        });
    });

    function errors_list(data) {
        $(function() {
            document.querySelector('#Errors').innerHTML = get_list(data);
            $('#ErrorModal').modal('show')
        });
    }
    function get_list(data) {
        let temp = '';
        if((typeof data) != 'string'){
            for (var error in data) {
                temp = temp + '<li>' + data[error] + "</li>";
            }
        }else{
            temp = '<li>' + data + "</li>";
        }
        return temp;
    }
});
</script>
@endsection
