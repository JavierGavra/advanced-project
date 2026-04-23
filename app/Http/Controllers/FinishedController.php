<?php

namespace App\Http\Controllers;

use App\Models\MasterTutorial;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class FinishedController extends Controller
{
    public function show(string $slug)
    {
        $master = MasterTutorial::where('finished_url', 'finished/' . $slug)
            ->firstOrFail();

        $details = $master->details()
            ->orderBy('order')
            ->get()
            ->map(function ($detail) {
                // Parse code field untuk semua detail bertipe code
                if ($detail->type === 'code') {
                    $detail->parsed = $detail->parsed_code;
                }

                // Convert gambar ke base64 agar bisa dirender DomPDF
                if ($detail->type === 'gambar' && $detail->gambar) {
                    $path = Storage::disk('public')->path($detail->gambar);
                    if (file_exists($path)) {
                        $mime = mime_content_type($path);
                        $b64  = base64_encode(file_get_contents($path));
                        $detail->gambar_base64 = "data:{$mime};base64,{$b64}";
                    }
                }

                return $detail;
            });

        $pdf = Pdf::loadView('finished.index', compact('master', 'details'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'dpi'                       => 150,
                'defaultFont'               => 'sans-serif',
                'isHtml5ParserEnabled'       => true,
                'isRemoteEnabled'            => false, // matikan remote, pakai base64
                'isFontSubsettingEnabled'    => true,
            ]);

        $filename = \Illuminate\Support\Str::slug($master->judul) . '.pdf';

        // 'inline' = tampil di browser, ganti dengan 'download' jika mau langsung download
        return $pdf->stream($filename);
    }
}
