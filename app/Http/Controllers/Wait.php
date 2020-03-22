<?php

namespace App\Http\Controllers;

use App\QueueUser;
use Illuminate\Http\Request;
use App\Queue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class Wait extends Controller
{
    //
    public function index(Request $request)
    {
        $queuesFromCookie = Cookie::get("Queues");
        $queues = explode(";", $queuesFromCookie);

        foreach ($queues as $q) {
            if ($q != "") {
                $user_uuid = Cookie::get("Queue" . $q);
                break;
            }
        }

        $queueUser = DB::table('queue_users')
            ->where('queue_users.uuid', '=', $user_uuid)
            ->first();

        $queue = Queue::where('id',"=",$queueUser->queue_id)->first();

        return view('warten')->with(compact('queue','queueUser'));

    }

    public function edit(Request $request){
        $queue_user_id = $request->input("cancelButton");
        $QueueUser = QueueUser::where('id',$queue_user_id)->first();

        $queuesFromCookie = Cookie::get("Queues");
        $queues = explode(";", $queuesFromCookie);

        foreach ($queues as $q) {
            if ($q != "") {
                $user_uuid = Cookie::get("Queue" . $q);
                break;
            }
        }

        //Sicherheitesmeachnismus
        if($user_uuid!=$QueueUser->uuid){
            return redirect('/');
        }

        $queue = Queue::where('id',$QueueUser->queue_id)->first();

        QueueUser::where('id',$queue_user_id)->delete();

        $redirect = '/';
        return redirect($redirect);
    }
}
