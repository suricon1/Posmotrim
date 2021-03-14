<?php

namespace App\Console\Commands;

use App\Models\Blog\Post;
use Illuminate\Console\Command;

class YandexMetricAPI extends Command
{
    protected $signature = 'metric:start';

    public function handle()
    {
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Content-Type: application/x-yametrika+json',
                    "Authorization: OAuth AgAAAAAG6A33AAYBULcb3tP6V09YkgVZ5gweOaU"
                ]
            ]
        ];

        $url = 'https://api-metrika.yandex.ru/stat/v1/data?';
        $url .= '&ids=54737767';
        $url .= '&metrics=ym:pv:pageviews,ym:pv:users';
        $url .= '&dimensions=ym:pv:URLHash';
        $url .= '&date1=2019-01-01';
        $url .= '&date2=today';
        $url .= '&accuracy=full';
        $url .= '&limit=100000';
        $url .= '&proposed_accuracy=false';

        $metrikaRequest = file_get_contents($url, false, stream_context_create($options));

        if ( !empty($metrikaRequest) ) {

            $countPeopleView = json_decode($metrikaRequest, true)['data'];

            foreach ($countPeopleView as $value) {
                preg_match("~^https://vinograd-minsk.by/blog/(.+)\.html$~", $value['dimensions'][0]['name'], $matches);
                if ($matches && $value['metrics'][0] > 0){
                    Post::where('slug', $matches[1])->update(['view' => $value['metrics'][0]]);
                }
            }
        }
    }
}

/*
 * https://api-metrika.yandex.ru/stat/v1/data?&ids=54737767&metrics=ym:pv:pageviews,ym:pv:users&dimensions=ym:pv:URLHash&date1=2019-01-01&date2=today&accuracy=full&limit=100000&proposed_accuracy=false
 *
 */


//  ======== Вар1 ==========
//$url = 'https://api-metrika.yandex.ru/stat/v1/data';
//
//$params = [
//    'ids'         => '14446750',
//    'oauth_token' => 'Z4AAAAAYZjVkAAQP-FYZ6SJdSkhesN0MJ0dXOZo',
//    'metrics'     => 'ym:s:visits,ym:s:pageviews,ym:s:users',
//    'dimensions'  => 'ym:s:date',
//    'date1'       => '7daysAgo',
//    'date2'       => 'yesterday',
//    'sort'        => 'ym:s:date',
//];
//
//echo file_get_contents( $url . '?' . http_build_query($params) );

//  ======== Вар2 ==========
//$token = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
//
//$params = array(
//    'ids'     => 'Номер счетчика',
//    'metrics' => 'ym:s:visits,ym:s:pageviews,ym:s:users,ym:s:bounceRate,ym:s:pageDepth,ym:s:avgVisitDurationSeconds',
//    'date1'   => 'today', // 7daysAgo - неделя, 30daysAgo - месяц, 365daysAgo - год
//    'date2'   => 'today',
//);

//$ch = curl_init('https://api-metrika.yandex.net/stat/v1/data/bytime?' . urldecode(http_build_query($params)));
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $token));
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_HEADER, false);
//$res = curl_exec($ch);
//curl_close($ch);
//
//$res = json_decode($res, true);
////print_r($res);
//
//// Визиты
//echo $res['totals'][0][0];
//
//// Просмотры
//echo $res['totals'][0][1];
//
//// Посетители
//echo $res['totals'][0][2];
//
//// Отказы, %
//echo $res['totals'][0][3];
//
//// Глубина просмотра
//echo $res['totals'][0][4];
//
//// Время на сайте, сек.
//echo $res['totals'][0][5];
