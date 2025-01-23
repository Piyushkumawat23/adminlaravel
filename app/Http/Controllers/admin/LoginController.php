<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
   public function index(){
    return view('admin.login');
   }

   public function authenticate(Request $request)

   {

    $validadtor = validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);
    if ($validadtor->passes()) {
        if (auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            
            if (Auth::guard('admin')->user()->role != "admin") {
                Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('error','you are not authorized to access this page.');
                
            }
            
            
            
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.login')->with('error','Enter email or password is Invalid');
        }
    } else {
        return redirect()->route('admin.login')
            ->withInput()
            ->withErrors($validadtor);
    }
}

public function logout(){
    Auth::guard('admin')->logout();
    return redirect()->route('admin.login');
}

}
