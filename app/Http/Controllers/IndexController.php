<?php


namespace App\Http\Controllers;

use App\Poi;
use App\Queue;
use App\QueueUser;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
    public function index()
    {
        $chelper = new CookieHelper();
        $queues = $chelper->getQueueCookiesAsArray();
        $userQueues = array();
        foreach ($queues as $q) {
            if ($q != "") {
                $dbQueue = QueueUser::with(['queue', 'queue.poi'])->where("uuid", Cookie::get("Queue" . $q))->get();
                if (!$dbQueue->isEmpty()) {
                    if (!is_null($dbQueue[0]) && $dbQueue[0] != "") {
                        array_push($userQueues, $dbQueue[0]);
                    }
                } else {
                    //forget cookie
                    $chelper->forgetCookie("Queue" . $q);
                    $chelper->removeQueueIdFromBaseCookie($q);
                    return redirect("/"); //Workaround! Notwendig, da ein Cookie der bereits in der Queue ist nicht geupdatet werden kann
                }
            }
        }

        $queues = Queue::all();

        return view("welcome")->with(compact('userQueues', 'queues'));
    }
}


