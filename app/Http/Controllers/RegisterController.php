<?php

namespace App\Http\Controllers;

use App\Location;
use App\Poi;
use App\RegToken;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index($token){
        if(RegToken::where('token', $token)->first()){
            $expire = DB::table('reg_tokens')->where('token', $token)->first();
            $expire_date = Carbon::parse($expire->expire_date);
            if($expire_date->isPast()){
                return redirect(route('welcome'));
            }else{
                return view('registerForm');
            }
        }else{
            return view('welcome');
        }
    }

    public function register(Request $request){
        $validatedData = $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password_conf' => 'required',
            'poi_name' => 'required',
            'zip' => 'required'
        ]);


        if(User::where('email', $request->email)->first()){
            return back()->with('mailerror', 'Ihre E-Mail befindet sich schon im System. Bitte kontaktieren Sie uns.');
        }elseif ($request->password != $request->password_conf){
            return back()->with('passerror', 'Die beiden Passwörter sind nicht identisch.');
        }else{
            $user = new User();
            $user->name = $request->lastname;
            $user->name_first = $request->firstname;
            $user->company = $request->poi_name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            if(Location::where('zip', $request->zip)->first()){
                $poi = new Poi();
                $poi->name = $request->poi_name;
                $existingZip = DB::table('locations')->where('zip', $request->zip)->first();
                $poi->location_id = $existingZip->id;
                $poi->admin_id = $user->id;
                $poi->save();
            }else{
                $location = new Location();
                $location->zip = $request->zip;
                $location->save();
                $poi = new Poi();
                $poi->name = $request->poi_name;
                $poi->location_id = $location->id;
                $poi->admin_id = $user->id;
                $poi->save();
            }
            Auth::loginUsingId($user->id);
            return redirect()->route('maintainer.dashboard')->withSuccess(['Sie haben sich erfolgreich registriert!']);
        }
    }
}
