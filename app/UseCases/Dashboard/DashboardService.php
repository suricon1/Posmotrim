<?php

namespace App\UseCases\Dashboard;

use App\Models\Vinograd\DeliveryMethod;
use App\Models\Vinograd\Order\Order;
use Illuminate\Http\Request;

class DashboardService
{

    public function getCompletedOrdersItemsArray($dateRange, $status)
    {
        return Order::
            leftJoin('vinograd_order_items as items', function ($join) {
                $join->on('vinograd_orders.id', '=', 'items.order_id');
            })->
            rightJoin('vinograd_products as prod', function ($join) {
                $join->on('prod.id', '=', 'items.product_id');
            })->
            rightJoin('vinograd_product_modifications as prod_mod', function ($join) {
                $join->on('prod_mod.id', '=', 'items.modification_id');
            })->
            rightJoin('vinograd_modifications as mod', function ($join) {
                $join->on('mod.id', '=', 'prod_mod.modification_id');
            })->
            select(
                'prod.name as product_name',
                'mod.name as modification_name',
                'items.price as price',
                'items.product_id as product_id',
                'items.modification_id as modification_id'
            )->
            selectRaw('
               `items`.`price` * SUM(`items`.`quantity`) as `cost`,
               SUM(`items`.`quantity`) as `allQuantity`
            ')->
            whereStatus($status)->
            timeRange($dateRange, $status)->
            groupBy('product_name', 'modification_name', 'price', 'product_id', 'modification_id')->
            orderByDesc('cost')->
            get()->
            groupBy('product_name')->
            all();
    }

    public function getSelectOrdersByNumbers($order_ids)
    {
        if (!$order_ids) return [];

        return Order::
        leftJoin('vinograd_order_items as items', function ($join) {
            $join->on('vinograd_orders.id', '=', 'items.order_id');
        })->
        rightJoin('vinograd_products as prod', function ($join) {
            $join->on('prod.id', '=', 'items.product_id');
        })->
        rightJoin('vinograd_product_modifications as prod_mod', function ($join) {
            $join->on('prod_mod.id', '=', 'items.modification_id');
        })->
        rightJoin('vinograd_modifications as mod', function ($join) {
            $join->on('mod.id', '=', 'prod_mod.modification_id');
        })->
        select(
            'prod.name as product_name',
            'mod.name as modification_name'
        )->
        selectRaw('SUM(`items`.`quantity`) as `allQuantity`')->
        //whereStatus(Order::ORDERED_LIST)->
        selectOrdersByNumbers($order_ids)->
        groupBy('product_name', 'modification_name')->
        get()->
        groupBy('product_name')->
        all();
    }

    public function getAllOrdersAsModfication($dateRange, $status, $product_id, $modification_id, $price)
    {
        return Order::with('items')->
            rightJoin('vinograd_order_items', function ($join) use ($product_id, $modification_id, $price) {
                $join->on('vinograd_orders.id', '=', 'vinograd_order_items.order_id')->
                       where('product_id', '=', $product_id)->
                       where('modification_id', '=', $modification_id)->
                       where('price', '=', $price);
            })->
            select('vinograd_orders.*')->
            whereStatus($status)->
            timeRange($dateRange, $status)->
            paginate(30)->appends(request()->except('page'));
    }

    public function getDataOnModifications ($dateRange, $status)
    {
        return $this->getRawData($dateRange, $status)->get();
    }

    public function getDataOnDeliverys ($dateRange, $status, $delivery_id)
    {
        return $this->getRawData($dateRange, $status)->
            where('delivery', 'like', '%"method_id":' . $delivery_id . '%')->
            get();
    }

    public function getDataOnDeliveryAll($dateRange, $status)
    {
        $array = [];
        $deliverys = DeliveryMethod::all();
        foreach ($deliverys as $delivery){
            $data = $this->getDataOnDeliverys ($dateRange, $status, $delivery->id)->
                groupBy('name')->
                map(function ($item) {
                    return [
                        'cost' => $item->sum('cost'),
                        'allQuantity' => $item->sum('allQuantity')
                    ];
                })->
                all();
            if(count($data)){
                $array[$delivery->name] = $data;
            }
        }
        return  $array;
    }

    private function getRawData($dateRange, $status)
    {
        return Order::
            leftJoin('vinograd_order_items as items', function ($join) {
                $join->on('vinograd_orders.id', '=', 'items.order_id');
            })->
            rightJoin('vinograd_product_modifications as prod_mod', function ($join) {
                $join->on('prod_mod.id', '=', 'items.modification_id');
            })->
            rightJoin('vinograd_modifications as mod', function ($join) {
                $join->on('mod.id', '=', 'prod_mod.modification_id');
            })->
            select(
                'mod.name as name',
                'items.price as price'
            )->
            selectRaw('
                   `items`.`price` * SUM(`items`.`quantity`) as `cost`,
                   SUM(`items`.`quantity`) as `allQuantity`
                ')->
            whereStatus($status)->
            timeRange($dateRange, $status)->
            groupBy('name', 'price')->
            orderByDesc('allQuantity');
    }

    public function getTotalCostCompletedOrders($dateRange, $status)
    {
        return $price = Order::whereStatus($status)->timeRange($dateRange, $status)->sum('cost');
    }

    public function getDateRange(Request $request)
    {
        if (!$request->has('from') || $request->from == null){
            return [
//                'from' => mktime(0, 0, 0, 1, 1, 2019),
                'from' => date("m") > '08'
                    ? mktime(0, 0, 0, 8, 1, date("Y"))
                    : mktime(0, 0, 0, 8, 1, date("Y") - 1),
                'to' => false
            ];
        }

        $from = explode("-", $request->from);
        $to = explode("-", $request->to);

        return [
            'from' => mktime(0, 0, 0, $from[1], $from[0], $from[2]),
            'to' => mktime(23, 59, 59, $to[1], $to[0], $to[2])
        ];
    }

    public function getTitleDate($dateRange)
    {
        ['from' => $from, 'to' => $to] = $dateRange;

        if (!$to && date("d.m", $from) == '01.08'){
            return ' <strong>за текущий сезон</strong>';
        }
        if (date("d.m.Y", $from) == '01.01.2019' && date("d.m.Y", $to) == date("d.m.Y") ){
            return ' <strong>за весь период</strong>';
        }
        if (date("d.m", $from) == '01.01' && date("d.m", $to) == '31.12'){
            return 'за <strong>'.date("Y", $from).' год</strong>';
        }
        if ((date("d.m.Y", $from) == date("d.m.Y", $to)) && date("d.m.Y", $from) == date("d.m.Y")){
            return 'за <strong>сегодня</strong>';
        }
        if (date("d.m.Y", $from) == date("d.m.Y", $to)){
            return 'за <strong>'. getRusDate($from, 'd %MONTH% Y, %DAYWEEK%') .'</strong>';
        }
        if (date("d.m.Y", $to) == date("d.m.Y")){
            return 'с <strong>'. getRusDate($from, 'd %MONTH% Y, %DAYWEEK%') .'</strong> по <strong>сегодня</strong>';
        }
        return 'с <strong>'. getRusDate($from, 'd %MONTH% Y, %DAYWEEK%') .'</strong> по <strong>'. getRusDate($to, 'd %MONTH% Y, %DAYWEEK%') .'</strong>';
    }

    public function StringToArray($string)
    {
        $string = preg_replace('/[^0-9\s,.]/', '', $string);
        $string = preg_split("/[\s,.]+/", $string);
        return array_diff($string, ['', NULL, false]);
    }

    public function ArrayToString($array)
    {
        return $array ? implode(', ', $array) : null;
    }
}
