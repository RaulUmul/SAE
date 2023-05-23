<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function acceso(Request $request){

         // return $request;
         // return User::all();

         $credenciales = $request->validate([
             'user'=>'required',
             'password'=>'required'
         ]);


//        return redirect('/sae');
         if(Auth::attempt(['user'=>$credenciales['user'],'password'=>$credenciales['password']])) {
            Auth::login(
              User::select('id_user')->where('user',$credenciales['user'])->first()
            );

          return redirect()->intended('/sae');
         }else{
//          Retornar que no coincide las credenciales no?
           return 'No coinciden lo que ingresaste we! :v';
         }
//             return redirect()->intended();
//        \Session::flush();

//         }else{
             // echo ValidationException::withMessages([
             //     'No existe nada.'
             // ]);
//             dd(Auth::attempt(['user'=>$credenciales['user'],'password'=>$credenciales['password']]));

//             return redirect()->intended();

//         }



//         $request->session()->regenerate();




    }

    public function registro(Request $request){

      $credenciales = $request->validate([
        'user'=>'required',
        'password'=>['required','confirmed',Rules\Password::defaults()]
      ]);


      $lastId = DB::table('public.users')->max('id_user');
      $newId = $lastId + 1;
      $user = new User();
        $user->id_user = $newId;
        $user->user = $request->user;
        $user->password = bcrypt($request->password);
      $user->save();

      Auth::login($user);
      return redirect()->intended('/sae');

    }

    public function logout(){
      \Session::flush();
      Auth::logout();
      return redirect()->intended('/');
    }
}
