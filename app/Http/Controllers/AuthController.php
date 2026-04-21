<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index () {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email:dns',
            'password'=>'required'
        ]);

        $response = Http::post('https://jwt-auth-eight-neon.vercel.app/login', $credentials);
        if ($response->failed()) {
            return redirect('/login')->with('error', 'Login gagal. Silakan coba lagi.');
        }

        $data = $response->json();
        Session::put('refresh_token', $data['refreshToken']);
        Session::put('user_email', $credentials['email']);
        Session::put('is_logged_in', true);
        return $response->json();
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
