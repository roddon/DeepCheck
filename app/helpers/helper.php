<?php

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Currency;
use App\Models\Language;

if (!function_exists('getActiveDistributors')) {
    /*
        Common function to get active distributors.
    */
    function getLanguages()
    {
        return Language::get()->pluck('name', 'id');
    }

    function getCurrency()
    {
        return Currency::get()->pluck('code', 'id');
    }
}

if (!function_exists('convertRate')) {
    function convertRate($price, $from, $to)
    {
        if ($from != $to) {
            $lastDate = $yesterday = Carbon::yesterday()->format('Y-m-d');
            $todaysDate = Carbon::now()->format('Y-m-d');

            $weekDay = date('w', strtotime($yesterday));

            if ($weekDay == 0 || $weekDay == 6) {
                $searchDay = 'Friday';
                $searchDate = Carbon::yesterday();
                $lastFriday = Carbon::createFromTimeStamp(strtotime("last $searchDay", $searchDate->timestamp));
                $lastDate = $lastFriday->format('Y-m-d');
            }

            $url = 'https://api.exchangeratesapi.io/history?start_at='.$lastDate.'&end_at='.$todaysDate.'&base='.$from.'&symbols='.$to;
            $client = new Client(['verify' => false]);
            $responce = json_decode($client->get($url)->getBody()->getContents(), true);
            $liveToRate = $responce['rates'][$lastDate][$to];

            return round($price * $liveToRate, 2);
        }
        return $price;        
    }
}