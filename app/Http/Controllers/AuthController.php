<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){

        // // return $request;
        // // return User::all();

        // $credenciales = $request->validate([
        //     'user'=>'required',
        //     'password'=>'required'
        // ]);

        // // dd($credenciales);
        // // dd(Auth::login());
        // // dd(Auth::attempt($credenciales));
        // if(Auth::attempt(['user'=>$credenciales['user'],'password'=>$credenciales['password']])){
        //     // dd(Auth::login());

        //     return redirect()->intended();

        // }else{
        //     // echo ValidationException::withMessages([
        //     //     'No existe nada.'
        //     // ]);
        //     dd(Auth::attempt(['user'=>$credenciales['user'],'password'=>$credenciales['password']]));

            // return redirect()->intended();

        // }



        // $request->session()->regenerate();

        


    }
}
