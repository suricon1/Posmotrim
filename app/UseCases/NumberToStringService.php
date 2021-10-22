<?php

namespace App\UseCases;

class NumberToStringService
{
    const Null = 'ноль';
    const TEN = [
        ['','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'],
        ['','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять']
    ];
    const A20 = ['десять','одиннадцать','двенадцать','тринадцать','четырнадцать',
                'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать'];
    const TENS = [2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто'];
    const HUNDRED = ['','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот'];
    const UNIT = [ // Units
            ['коп.' ,'коп.' ,'коп.',	 1],
            ['руб.'   ,'руб.'   ,'руб.'    ,0],
//            ['копейка' ,'копейки' ,'копеек',	 1],
//            ['рубль'   ,'рубля'   ,'рублей'    ,0],
            ['тысяча'  ,'тысячи'  ,'тысяч'     ,1],
            ['миллион' ,'миллиона','миллионов' ,0],
            ['миллиард','милиарда','миллиардов',0],
        ];

    public function numberToRussian ($num) {
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof(self::UNIT)-$uk-1; // unit key
                $gender = self::UNIT[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = self::HUNDRED[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= self::TENS[$i2].' '.self::TEN[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? self::A20[$i3] : self::TEN[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= $this->morph($v,self::UNIT[$uk][0],self::UNIT[$uk][1],self::UNIT[$uk][2]);
            }
        } else {
            $out[] = self::Null;
        }

        $out[] = $this->morph(intval($rub), self::UNIT[1][0],self::UNIT[1][1],self::UNIT[1][2]); // rub
        $out[] = $kop.' '.$this->morph($kop,self::UNIT[0][0],self::UNIT[0][1],self::UNIT[0][2]); // kop

        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }

    public function numberToCostFormat ($num)
    {
        return number_format($num, 2, ' руб. ', ' ') . ' коп.';
    }

    private function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }
}
