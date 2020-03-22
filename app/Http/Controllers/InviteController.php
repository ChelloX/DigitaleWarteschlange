<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InviteController extends Controller
{
    function generate_string($input, $strength) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
    public function index(){
        if(auth()->user()->is_admin == 1){
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $regtoken = $this->generate_string($permitted_chars, 32);


            return view('admin.invite')->with(compact('regtoken'));
        }else{
            return redirect(route('maintainer.dashboard'));
        }

    }
}
