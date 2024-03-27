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
                    <th>Цена</th>
                    <th>Всего</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td style="font-size: 130%;">
                            {{$item->product_name}}<br>
                            <strong>{{$item->modification_name}}</strong>
                        </td>
                        <td style="font-size: 130%;">{{$item->quantity}} шт.</td>
                        <td>{{$item->price}} р</td>
                        <td>{{$item->getCost()}} р</td>
                    </tr>
                @endforeach
                <tr>
{{--                    <th>Всего</th>--}}
                    <td colspan="2" style="font-size: 130%;" class="pt-4">
                        @foreach ($quantityByModifications as $name => $value)
                            <p>{{$name}}: <strong>{{$value}}</strong> шт</p>
                        @endforeach
                    </td>
{{--                    <td>Итого:</td>--}}
                    <td  colspan="2" class="pt-4">
                        Итого: <strong>{{$order->getTotalCost()}}</strong> р <br>
{{--                        ({{mailCurr($currency, $order->getTotalCost())}} {{$currency->sign}})--}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
