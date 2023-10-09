<?php

namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }  
      
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            if(Auth::user()->is_active == 1 && Auth::user()->is_deleted == 0){
                return redirect()->intended('dashboard')->withSuccess('Signed in');
            }else{
                auth()->guard()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withInput()->with('status', 'You are not allowed to access!');
            }
        }
  
        return redirect()
            ->back()
            ->withInput()
            ->with('status', 'These credentials do not match our records.');
    }

    
    
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
