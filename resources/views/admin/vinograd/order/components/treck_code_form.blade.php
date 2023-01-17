<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">Отправить трек код</h3>
    </div>
    <div class="card-body">
        {{Form::open(['route' => 'orders.sent.status.mail', 'data-ajax-url' => route('orders.set_ajax_treck_code')])}}
        {!! Form::hidden('order_id', $id) !!}
        <div class="input-group input-group-sm">
            <input name="track_code" type="text" class="form-control">
            <span class="input-group-append">
                <button type="submit" class="btn btn-info btn-flat">Отправить</button>
            </span>
        </div>
        {{Form::close()}}
    </div>
</div>
