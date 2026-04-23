<?php

namespace App\Http\Controllers;

use App\Models\MasterTutorial;
use Illuminate\Http\Request;

class PresentationController extends Controller
{
    /**
     * Tampilkan halaman presentation publik.
     * Hanya detail dengan status = 'show', diurutkan by order.
     */
    public function show(string $slug)
    {
        $master = MasterTutorial::where('presentation_url', 'presentation/' . $slug)
            ->firstOrFail();

        $details = $master->details()
            ->where('status', 'show')
            ->orderBy('order')
            ->get();

        return view('presentation.index', compact('master', 'details'));
    }

    /**
     * Endpoint polling untuk auto-refresh.
     * Mengembalikan hash dari kondisi detail saat ini.
     * Jika hash berubah, client akan reload halaman.
     */
    public function poll(string $slug)
    {
        $master = MasterTutorial::where('presentation_url', 'presentation/' . $slug)
            ->firstOrFail();

        // Ambil id + status semua detail, buat hash unik kondisi saat ini
        $state = $master->details()
            ->orderBy('order')
            ->get(['id', 'status', 'updated_at'])
            ->toJson();

        return response()->json([
            'hash' => md5($state),
        ]);
    }
}
