<?php


namespace App\Http\Controllers;


use App\Poi;
use App\Queue;

class QrController extends Controller
{
    public function queueQr($uuid) {
        $queue = Queue::where('uuid', $uuid)->get();
        $poi = Poi::where('id', $queue[0]['poi_id'])->get();
        $poi = $poi[0];
        $queue = $queue[0];
        return view('qrCheck')->with(compact('poi', 'queue'));
    }
}
