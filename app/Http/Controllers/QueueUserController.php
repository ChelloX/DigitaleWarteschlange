<?php

namespace App\Http\Controllers;

use App\Queue;
use App\QueueUser;
use App\User;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class QueueUserController extends Controller
{

    public function postQueueUser(Request $request)
    {
        return $this->queueUserInQueueQR($request->input('applyBtn'));
    }

    public function postDequeueUser(Request $request)
    {
        $queueUser = QueueUser::where("uuid", $request->input('applyBtn'))->get();
        if (sizeof($queueUser) == 0) {
            return redirect("/");
        } elseif (sizeof($queueUser) == 1) {
            return $this->dequeueUserFromQueue($queueUser[0]["queue_id"]);
        }
    }


    public function queueUserInQueueQR($queueUuidToQueueUser)
    {
        $queueId = Queue::where("uuid", $queueUuidToQueueUser)->get();

        return $this->queueUserInQueue($queueId[0]["id"]);
    }

    private function queueUserInQueue($queueIdToQueueUser)
    {
        $chelper = new CookieHelper();

        //Checken, ob der User schon einen Cookie hat und für diese Queue angemeldet ist
        $queuesFromCookie = $chelper->getQueueCookiesAsArray();

        foreach ($queuesFromCookie as $q) {
            if ($q == $queueIdToQueueUser) { //User hat bereits einen Cookie für diese ID, Checken ob dieser noch aktuelle - auf der DB - ist
                if (QueueUser::where("uuid", Cookie::get("Queue" . $q)[0])->get()) {
                    return redirect("/");
                } else {
                    $chelper->forgetCookie("Queue" . $q);
                }
            }
        }

        $queueToId = Queue::where("id", $queueIdToQueueUser)->get();

        if (sizeof($queueToId) == 0) {
            return response("Keine Queue zu ID " . $queueIdToQueueUser . " vorhanden");
        }

        $uuid = $this->generateRandomString(32);

        $qUser = new QueueUser();
        $qUser['queue_id'] = $queueToId[0]['id'];
        $qUser['uuid'] = $uuid;
        $qUser['wartenummer'] = count(QueueUser::where("queue_id", $queueIdToQueueUser)->get()) + 1;
        $qUser->save();


        $chelper->addQueueIdToBaseCookie($queueToId[0]['id']);
        $chelper->createCookie("Queue" . $queueToId[0]['id'], $uuid);
        return redirect('/');
    }

    private function dequeueUserFromQueue($queueIdToDequeueUser)
    {
        $chelper = new CookieHelper();
        $queues = $chelper->getQueueCookiesAsArray();
        if (!is_null($queues)) {
            foreach ($queues as $q) {

                if ($q == $queueIdToDequeueUser) {
                    if ($q != "") {
                        $dbQueue = QueueUser::where("uuid", Cookie::get("Queue" . $q))->get();
                        if (count($dbQueue) == 0) {
                            $chelper->forgetCookie("Queue" . $q);
                            $chelper->removeQueueIdFromBaseCookie($q);
                            return redirect("/");
                        } elseif (count($dbQueue) > 1) {
                            return response("Schwerwiegender Fehler!!! Mehrere Einträge in Queue_User zu einer UUID");
                        } else {
                            $dbQueue[0]->delete();

                            $chelper->forgetCookie("Queue" . $q);
                            $chelper->removeQueueIdFromBaseCookie($q);

                            return redirect('/');
                        }
                    }
                }
            }
        }
    }

    private function generateRandomString($length)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }


//    public function coockieCheck()
//    {
//        $queuesFromCookie = Cookie::get("Queues");
//        $queues = explode(";", $queuesFromCookie);
//
//        foreach ($queues as $q) {
//            echo Cookie::get("Queue" . $q) . "<br>";
//        }
//        var_dump($queuesFromCookie);
//    }
}
