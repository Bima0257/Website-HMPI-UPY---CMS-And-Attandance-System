<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('dashboard.login.index', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect ke dashboard jika level pengguna sesuai
            if (Auth::user()->level_pengguna === 'Admin' || Auth::user()->level_pengguna === 'Super Admin') {
                return redirect()->intended('/dashboard');
            }

            // Logout jika bukan admin atau super admin
            Auth::logout();
            return redirect('/dashboard/login')->with('loginError', 'Anda tidak memiliki akses.');
        }


        return back()->with('loginError', 'Incorrect username and password!');
    }

    public function Logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/dashboard/login');
    }
}
