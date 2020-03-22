<?php

namespace App\Http\Controllers;

use App\RegToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendRegistrationMail;
use Carbon\Carbon;



class SendEmailController extends Controller
{
    public function send(Request $request){
        if(auth()->user()->is_admin == 1){
            $validatedData = $request->validate([
                'regtoken' => 'required',
                'regLink' => 'required',
                'mailto' => 'required|email'
            ]);
            $mailto = $request->mailto;

            $data = array(
                'regLink' => $request->regLink,
            );

            $regEntry = new RegToken();
            $regEntry['token'] = $request->regtoken;
            $regEntry['expire_date'] = Carbon::now()->addDays(7);
            $regEntry->save();

            Mail::to($mailto)->send(new SendRegistrationMail($data));

            return back()->with('success', 'Hat alles geklappt!');
        }else{
            return redirect(route('maintainer.dashboard'));
        }
    }
}
