<?php

namespace App\Http\Controllers;

use App\Queue;
use App\QueueUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueueDetail extends Controller
{
    public function index(Request $request)
    {
        $queueid = $request->input("id");
        if(!$this->checkQueueAuth($queueid)){
            return redirect('/maintainer/manageQueue');
        }

        $queue = DB::table('queues')
            ->where('queues.id', '=', $queueid)
            ->get()[0];

        $queueUsers = DB::table('queue_users')
            ->where('queue_users.queue_id', '=', $queueid)
            ->get();

        return view('maintainer.queueDetail')->with(compact('queue','queueUsers'));

    }

    private function checkQueueAuth(int $queue_id){
        $user = auth()->user()->id;

        $queues = DB::table('queues')
            ->join('pois', 'queues.poi_id', '=', 'pois.id')
            ->where('pois.admin_id', '=', $user)
            ->where('queues.id', '=', $queue_id)
            ->count();

        if($queues>0){
            return true;
        }else{
            return false;
        }

    }

    public function pop(Request $request){

        $queueid = $request->input("popButton");
        if(!$this->checkQueueAuth($queueid)){
            return redirect('/maintainer/manageQueue');
        }

        $queue = Queue::where('queues.id', '=', $queueid)
            ->first();
        $QueueUser = QueueUser::where('queue_id',$queueid)->orderBy('wartenummer', 'asc')->first();
        $queue->current_user = $QueueUser->wartenummer;
        $queue->save();

        QueueUser::where('queue_id',$queueid)->first()->delete();

        $redirect = '/maintainer/queueDetail?id='.$queue->id;
        return redirect($redirect);
    }

    public function skipUser(Request $request){

        $queue_user_id = $request->input("skipButton");
        $QueueUser = QueueUser::where('id',$queue_user_id)->first();
        $queue = Queue::where('id',$QueueUser->queue_id)->first();
        if(!$this->checkQueueAuth($queue->id)){
            return redirect('/maintainer/manageQueue');
        }

        //$queue->current_user = $QueueUser->wartenummer;
        //$queue->save();

        QueueUser::where('id',$queue_user_id)->delete();

        $redirect = '/maintainer/queueDetail?id='.$queue->id;
        return redirect($redirect);
    }

    public function editQueue(Request $request){
        $queueid = $request->input("queue_id");
        if(!$this->checkQueueAuth($queueid)){
            return redirect('/maintainer/manageQueue');
        }
        $queue = Queue::where('id',$queueid)->first();
        if($request->input('info')){
            $queue->info = $request->input('info');
        }
        if($request->input('close_time')){
            $queue->close_time = $request->input('close_time');
        }
        if($request->input('status')){
            $queue->status = $request->input('status');
        }
        $queue->save();

        $redirect = '/maintainer/queueDetail?id='.$queue->id;
        return redirect($redirect);
    }
}
