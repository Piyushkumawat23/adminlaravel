<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rules\Email;

class LoginController extends Controller
{
    public function index()
    {

        return view('user.login');
    }

    public function authenticate(Request $request)
    {

        $validadtor = validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validadtor->passes()) {
            if (auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.dashboard');
            } else {
                return redirect()->route('account.login')->with('error','Enter email or password is Invalid');
            }
        } else {
            return redirect()->route('account.login')
                ->withInput()
                ->withErrors($validadtor);
        }
    }


    public function register()
    {


        return view('register');
    }


    public function processRegister(Request $request)
    {

        $validadtor = validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required',
            'name' => 'required',
        ]);
        if ($validadtor->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role ='customer';
            $user->save();
            return redirect()->route('account.login')->with('success','you have successfully registered ');
        } else {
            return redirect()->route('account.register')
                ->withInput()
                ->withErrors($validadtor);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
}
}