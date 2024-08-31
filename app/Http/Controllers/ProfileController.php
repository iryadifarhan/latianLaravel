<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function display_profile(){
        $user = Auth::user();

        return view('edit_profile', compact('user'));
    }

    public function change_profile(Request $request){
        $request->validate([
            'name' => 'nullable|min:3',
            'password' => 'nullable|confirmed|min:8'
        ]);

        $user = Auth::user();
        $name_input = ($request->name != null) ? $request->name : $user->name;
        $pass_input = ($request->pass != null) ? Hash::make($request->password) : $user->password;
        
        $user->update([
            'name' => $name_input,
            'password' => $pass_input
        ]);

        return Redirect::back();
    }
}
