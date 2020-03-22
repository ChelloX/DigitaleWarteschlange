<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintainerController extends Controller
{
    public function index(){
        $lastname = auth()->user()->name;
        $firstname = auth()->user()->name_first;
        return view('maintainer.dashboard')->with(compact('lastname', 'firstname'));
    }
}
