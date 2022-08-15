<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

if (!function_exists('formatPrice')){
    function formatPrice($price){
        return 'Rp.' . number_format($price,0,'',',') . ',-';
    }
}

if(!function_exists('getIdulAdha')){
    function getIdulAdha(){
        $thisYear = now()->format('Y');
        $nextYear = now()->addYear()->format('Y');

        $response = Http::get("https://www.googleapis.com/calendar/v3/calendars/en.indonesian%23holiday%40group.v.calendar.google.com/events?key=AIzaSyCW-GgbApaXiAl08ret7hGlBHhqFIpF-6Q")->json();
        $path = "Idul Adha";

        $thisIdulAdha = null;
        $nextIdulAdha = null;

        foreach ($response['items'] as $item) {
            if (strpos($item['summary'], $path) !== false) {
                $date = Carbon::createFromFormat('Y-m-d', $item['start']['date']);
                if($date->format('Y') == $thisYear) {
                    $thisIdulAdha = $date;
                } else if($date->format('Y') == $nextYear) {
                    $nextIdulAdha = $date;
                }
            }
        }

        return $thisIdulAdha > now() ? $thisIdulAdha : $nextIdulAdha;
    }
}
