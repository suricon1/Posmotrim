<?php

namespace App\Console\Commands;

use App\Mail\Admin\CurrencyErrorMail;
use App\Models\Vinograd\Currency;
use Illuminate\Console\Command;
use Mail;

class CurrencyExchange extends Command
{
    protected $signature = 'currency:exchange';

    public function handle()
    {
        $currency = Currency::where('code', '<>', 'BYN')->get();
        $arrContextOptions = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
        ];
        foreach ($currency as $item){
            try {
                $val = json_decode(file_get_contents('https://www.nbrb.by/api/exrates/rates/'.$item->code.'?parammode=2', false, stream_context_create($arrContextOptions)));
//                $val = json_decode(file_get_contents('http://www.nbrb.by/API/ExRates/Rates/'.$item->code.'?ParamMode=2'));
            }catch (\Exception $e){
                Mail::to(config('main.admin_email'))->queue(new CurrencyErrorMail($e->getMessage()));
                continue;
            }
            $item->scale = $val->Cur_Scale;
            $item->rate = $val->Cur_OfficialRate * 0.98;
            $item->save();
        }
    }

    private function file_get_contents_curl( $url ) {

        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

        $data = curl_exec( $ch );
        curl_close( $ch );

        return $data;
    }
}

//https://www.nbrb.by/api/exrates/rates/USD?parammode=2
//http://www.nbrb.by/API/ExRates/Rates/USD??ParamMode=2
//{"Cur_ID":145,"Date":"2020-11-16T00:00:00","Cur_Abbreviation":"USD","Cur_Scale":1,"Cur_Name":"Доллар США","Cur_OfficialRate":2.5668}
