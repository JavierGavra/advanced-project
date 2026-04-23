<?php

namespace App\Http\Controllers;

use App\Services\ExternalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $externalService;

    public function __construct(ExternalService $externalService)
    {
        $this->externalService = $externalService;
    }

    public function index () {
        if (Session::get('is_logged_in')) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email:dns',
            'password'=>'required'
        ]);

        $success = $this->externalService->login(
            $credentials['email'], 
            $credentials['password']
        );

        if (!$success) {
            return redirect('/login')->with('error', 'Login gagal. Silakan coba lagi.');
        }

        return redirect('/');
    }

    public function logout()
    {
        $this->externalService->logout();
        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
