<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ExternalService
{
    protected string $baseUrl = 'https://jwt-auth-eight-neon.vercel.app';

    public function login(string $email, string $password): bool
    {
        $response = Http::post("{$this->baseUrl}/login", [
            'email'    => $email,
            'password' => $password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            Session::put('refresh_token', $data['refreshToken'] ?? $data['refreshToken']);
            Session::put('user_email', $email);
            Session::put('is_logged_in', true);

            return true;
        }

        return false;
    }

    public function getMakul()
    {
        $token = Session::get('refresh_token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get("https://jwt-auth-eight-neon.vercel.app/getMakul");

        if ($response->failed()) {
            $this->logout();
            return [];
        };

        $matkul = [];
        foreach ($response['data'] as $item) {
            $matkul[] = $item['kdmk'] . ' - ' . $item['nama'];
        }

        return $matkul;
    }

    public function logout(): bool
    {
        $token = Session::get('refresh_token');

        if ($token) {
            Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post("{$this->baseUrl}/logout");
        }

        Session::flush();
        return true;
    }
}