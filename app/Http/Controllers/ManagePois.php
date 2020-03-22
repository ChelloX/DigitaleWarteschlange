<?php

namespace App\Http\Controllers;

use App\Location;
use App\Poi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagePois extends Controller
{
    //
    public function index(){

        $pois = DB::table('pois')
            ->get();

        return view('admin.managePoi')->with(compact('pois'));
    }

    public function delete(Request $request){

        $id = $request->input("deleteButton");
        $res=Poi::where('id',$id)->delete();

        //$res->save();
        return redirect('/admin/managePoi');
    }
}
