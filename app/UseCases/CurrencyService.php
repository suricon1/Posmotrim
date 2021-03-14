<?php

namespace App\UseCases;

use App\Models\Vinograd\Currency;
use Cookie;

class CurrencyService
{
    private $currency;

    protected static $instance;
    public static function Currency()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private  function __construct()
    {
        if (!$currency = Cookie::get('cur_code')){
            $is_bot = preg_match("~(Google|Yahoo|Rambler|Bot|Yandex|Spider|Snoopy|Crawler|Finder|Mail|curl)~i", $_SERVER['HTTP_USER_AGENT']);

            try {
                $client  = @$_SERVER['HTTP_CLIENT_IP'];
                $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];

                if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
                elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
                else $ip = @$_SERVER['REMOTE_ADDR'];

                $currency = !$is_bot ? json_decode(file_get_contents('http://api.sypexgeo.net/json/'.$ip), true)['country']['cur_code'] : 'BYN';
            } catch (\Exception $e) {
                $currency = 'BYN';
            }
            if (!in_array($currency, ['BYN', 'RUB', 'EUR', 'USD'])){
                $currency = 'BYN';
            }
            Cookie::queue('cur_code', $currency, 86400);
        }
        $this->currency = Currency::where('code', $currency)->first() ?: Currency::where('code', 'BYN')->first();
    }

    public function price($price)
    {
        return number_format($price * $this->currency->scale / $this->currency->rate, 2, '.', '');
    }

    public function sign()
    {
        return $this->currency->sign;
    }

    public function realCurrency()
    {
        return $this->currency;
    }
}
