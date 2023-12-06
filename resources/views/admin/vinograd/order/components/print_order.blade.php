<div class="col-6 ml-2 mt-3">
    <div class="row">
        <div class="col-12">
            <h5>№: <strong>{{$order->id}}</strong></h5>
            <p>{{$order->delivery['method_name']}}</p>
            <p>{{$order->customer['name']}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-sm table-striped">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Кол-во</th>
                    <th>Цена за шт.</th>
                    <th>Всего</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>
                            {{$item->product_name}}<br>
                            <strong>{{$item->modification_name}}</strong>
                        </td>
                        <td>{{$item->quantity}} шт.</td>
                        <td>{{$item->price}} бел. руб</td>
                        <td>{{$item->getCost()}} бел. руб</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Всего</th>
                    <td>
                        @foreach ($quantityByModifications as $name => $value)
                            <p>{{$name}}: <strong>{{$value}}</strong> шт</p>
                        @endforeach
                    </td>
                    <td>Итоговая стоимость:</td>
                    <td>
                        <strong>{{$order->getTotalCost()}}</strong> бел. руб <br>
                        ({{mailCurr($currency, $order->getTotalCost())}} {{$currency->sign}})
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
