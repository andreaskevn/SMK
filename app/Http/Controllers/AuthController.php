<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        if (Auth::check()) {
            return redirect('/dashboard')->with('alert', 'Kamu sudah login!');
        }        
        return view('auth.login');
    }

    public function showRegister() {
        if (Auth::check()) {
            return redirect('/dashboard')->with('alert', 'Kamu sudah login!');
        }
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|email|unique:users,users_email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'users_name' => $request->users_name,
            'users_email' => $request->users_email,
            'password' => bcrypt($request->password),
            'id_role' => 1,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function login(Request $request) {
        $credentials = $request->only('users_email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'users_email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

