<?php

use \App\Status\Status;

if (!function_exists('getRusDate'))
 {
    function getRusDate(/*$dateTime */ $timestamp, $format = '%DAYWEEK%, d %MONTH% Y H:i', $offset = 3)
    {
        $monthArray = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
        $daysArray = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];

        //$timestamp = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dateTime)->timestamp; // преобразует дату в метку времени
        $timestamp += 3600 * $offset;   // Смещение на указанное число часов

        $findArray = ['/%MONTH%/i', '/%DAYWEEK%/i'];
        $replaceArray = [$monthArray[date("m", $timestamp) - 1], $daysArray[date("N", $timestamp) - 1]];
        $format = preg_replace($findArray, $replaceArray, $format);

        return date($format, $timestamp);
    }
}

if (!function_exists('getArray'))
{
    function getArray($array)
    {
        $temp = [];
        foreach ($array as $key => $value){
            $n = mb_strtoupper(mb_substr($value, 0, 1, 'UTF-8')); // Получаем первую букву слова в верхнем регистре
            data_set($temp, "{$n}.{$key}", $value);
        }
        return $temp;
    }
}

if (!function_exists('getArrayToMenu'))
{
    function getArrayToMenu($array)
    {
        $array = getArray($array);
        $temp = [];
        $i = 0;
        $j = 1;
        foreach ($array as $key => $value)
        {
            $i ++;
            data_set($temp, "{$j}.{$key}", $value);
            if( $i == $j * ceil(count($array) / 4)) $j ++;
        }
        return $temp;
    }
}

if (! function_exists('wp_strip_all_tags'))
{
    function wp_strip_all_tags($string, $remove_breaks = false)
    {
        $string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
        $string = strip_tags($string);
        if ( $remove_breaks )
            $string = preg_replace('/[\r\n\t ]+/', ' ', $string);
        return trim( $string );
    }
}

if (! function_exists('getTree'))
{
    function getTree($data)
    {
        $tree = [];
        foreach ($data as $id=>&$node) {
            if (!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }
}

if (! function_exists('is_admin'))
{
    function is_admin()
    {
       return Auth::check() && Auth::user()->role == 3 ? true : false;
    }
}

if (! function_exists('strReplaceStrong')) {
    function strReplaceStrong($search, $str)
    {
        $arr = explode(" ", $search);
        foreach ($arr as $key => $value) {
            if (mb_strlen($value, 'UTF-8') < 2) continue;
            $str = preg_replace("/$value/iu", "<strong>$0</strong>", $str);
        }
        return $str;
    }
}

if (! function_exists('currency'))
{
    function currency($value)
    {
        return \App\UseCases\CurrencyService::Currency()->price($value);
    }
}

if (! function_exists('signature'))
{
    function signature()
    {
        return \App\UseCases\CurrencyService::Currency()->sign();
    }
}

if (! function_exists('realCurr'))
{
    function realCurr()
    {
        return \App\UseCases\CurrencyService::Currency()->realCurrency();
    }
}

if (! function_exists('mailCurr'))
{
    function mailCurr($currency, $value)
    {
        return number_format($value * $currency->scale / $currency->rate, 2, '.', '');
    }
}

if (! function_exists('statusList'))
{
    function statusList()
    {
        return Status::list();
    }
}

if (! function_exists('statusColor'))
{
    function statusColor($status)
    {
        return Status::statusColor((int) $status);
    }
}

if (! function_exists('ripeningProducts'))
{
    function ripeningProducts()
    {
        $temp = [];
        foreach (\App\Models\Vinograd\Category::$sortRipeningProducts as $key => $value) {
            $temp[$key] = $value . \App\Models\Vinograd\Category::$ripeningDays[$key];
        }
        return $temp;
    }
}

if (! function_exists('getModelName'))
{
    function getModelName($model)
    {
        return 'App\Models\Vinograd\\'.$model;
    }
}

if (! function_exists('formatPhone'))
{
    function formatPhone($phone)
    {
        //$phone = str_pad($phone, 10, '0', STR_PAD_LEFT);
        $phone = preg_replace('/^(80|0)(\d+)$/', '375$2', (string)$phone);
        return preg_replace('/^(\d{3})?(\d{2})?(\d{3})(\d{2})(\d{2})$/', '+\1 \2 \3 - \4 - \5', (string)$phone);
    }
}

if (! function_exists('formatNameBySimilar'))
{
    //  Меняем:
    //      Аркадия -> Аркадию
    //      Бажена -> Бажену
    //      Заря Несветая -> Зарю Несветую
    //      Интрига Ранняя -> Интригу Раннюю
    function formatNameBySimilar($string)
    {
        $pattern = [
            '/^(.+)яя$/i',
            '/^(.+)я$/i',
            '/^(.+)а$/i',
            '/^(.+)ая$/i'
        ];
        $replacement = [
            '\1юю',
            '\1ю',
            '\1у',
            '\1ую',
        ];
        $string = explode(" ", preg_replace('/^(.+)\s\(.+\)$/', '\1', $string));
        $string = preg_replace($pattern, $replacement, $string);

        return implode(" ", $string);
    }
}

if (! function_exists('statusNew'))
{
    function statusNew()
    {
        return Status::NEW;
    }
}

if (! function_exists('statusPreliminare'))
{
    function statusPreliminare()
    {
        return Status::PRELIMINARY;
    }
}

if (! function_exists('statusFormed'))
{
    function statusFormed()
    {
        return Status::FORMED;
    }
}

if (! function_exists('yearsQuery'))
{
    function yearsQuery()
    {
        return \App\UseCases\Dashboard\DashboardService::getArrayOfYears();
    }
}

if (! function_exists('flash'))
{
    function flash()
    {
        return app(App\Support\Flash\Flash::class);
    }
}
