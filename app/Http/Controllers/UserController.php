<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        return view('user.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->ai_admin) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('home');
            }
            
        }

        return redirect()->back()->with('error', 'Предоставленные учетные данные не соответствуют нашим записям.');
    }
}
