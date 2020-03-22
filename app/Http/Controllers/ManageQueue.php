<?php

namespace App\Http\Controllers;

use App\Poi;
use App\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageQueue extends Controller
{
    public function index()
    {

        $user = auth()->user()->id;

        $queues = DB::table('queues')
            ->join('pois', 'queues.poi_id', '=', 'pois.id')
            ->where('pois.admin_id', '=', $user)
            ->select('queues.*')
            ->get();

        return view('maintainer.manageQueue')->with(compact('queues'));

    }

    public function delete(Request $request){

        $id = $request->input("deleteButton");

        if(!$this->checkQueueAuth($id)){
            return redirect('/maintainer/manageQueue');
        }
        $res=Queue::where('id',$id)->delete();

        //$res->save();
        return redirect('/maintainer/manageQueue');
    }

    public function create(Request $request){

        $queue = new Queue();
        $queue['name'] = $request->input('name');
        $queue['uuid'] = uniqid();
        $queue['current_user'] = 0;
        $queue['status'] = 'pause';

        //Hier anpassen!!! user->poid
        $user = auth()->user()->id;
        $poid = Poi::where('admin_id',"=",$user)->first();
        $queue['poi_id'] = $poid->id;

        $queue->save();

        return redirect('/maintainer/manageQueue');
    }

}
