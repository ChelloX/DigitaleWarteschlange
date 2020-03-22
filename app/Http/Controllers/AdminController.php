<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        if(auth()->user()->is_admin == 1){
            $lastname = auth()->user()->name;
            $firstname = auth()->user()->name_first;
            return view('admin.dashboard')->with(compact('firstname','lastname'));
        }else{
            return redirect(route('maintainer.dashboard'));
        }

    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
