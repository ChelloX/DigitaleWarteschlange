<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Cookie;

class CookieHelper
{

    public function forgetCookie($cookieName) {
        Cookie::queue(Cookie::forget($cookieName));
    }

    public function removeQueueIdFromBaseCookie($queueId) {
        $baseCookie = Cookie::get("Queues");
        $baseCookie = str_replace($queueId . ";", "", $baseCookie);
        Cookie::queue(Cookie::make("Queues", $baseCookie, 1440));
    }

    public function addQueueIdToBaseCookie($queueId) {
        $baseCookie = Cookie::get("Queues");
        $baseCookie = $queueId . ";" . $baseCookie;

        Cookie::queue(Cookie::make("Queues", $baseCookie, 1440));
    }

    public function createCookie($cookieName, $cookieVal) {
        Cookie::queue(Cookie::make($cookieName, $cookieVal, 1440));
    }

    public function getQueueCookiesAsArray() {
        $queuesFromCookie = explode(";", Cookie::get("Queues"));

        if($queuesFromCookie[sizeof($queuesFromCookie) - 1] == "") {
            unset($queuesFromCookie[sizeof($queuesFromCookie) - 1]);
        }

        return $queuesFromCookie;
    }

}
