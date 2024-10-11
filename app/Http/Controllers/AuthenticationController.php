<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;


class AuthenticationController extends Controller
{
    //
    public function login(Request $request){

        //validate
        $user = $request->validate([
            'email'=>['required','email'],
            'password'=>['required','max:8'],
        ]);

        //login 

        if (Auth::attempt($user)) {

            $request->session()->regenerate();
        //redirect
            return redirect('/studentlist');

        }
        
    }

    public function store(Request $request){
        //dd($request);(string) Str::uuid();

        //validate

        $newuser = $request->validate([
            'name'=>['required','max:50'],
            'email'=>['required','email'],
            'password'=>['required','confirmed']
        ]);


        //create user
        $user = User::create($newuser);
        
        //login
        Auth::login($user);


        //redirect

        return redirect('/studentlist');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->regenerateToken();
        return redirect('/');

    }
}
