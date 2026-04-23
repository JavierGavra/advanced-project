<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterTutorial;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index(string $kode_matkul)
    {
        $tutorials = MasterTutorial::where('kode_matkul', $kode_matkul)->get();

        if ($tutorials->isEmpty()) {
            return response()->json([
                'status' => [
                    'code' => 404,
                    'description' => "Not Found data $kode_matkul"
                ],
                'results' => []
            ], 404);
        }

        return response()->json([
            'status' => [
                'code' => 200,
                'description' => 'OK'
            ],
            'results' => $tutorials->map(function ($item) {
                return [
                    'id'               => $item->id,
                    'kode_matkul'      => $item->kode_matkul,
                    'nama_matkul'      => $item->nama_matkul ?? null,
                    'judul'            => $item->judul,
                    'url_presentation' => url($item->presentation_url),
                    'url_finished'     => url($item->finished_url),
                    'creator_email'    => $item->creator_email,
                    'created at'       => $item->created_at->format('Y-m-d H:i:s'),
                    'updated at'       => $item->updated_at->format('Y-m-d H:i:s'),
                ];
            })
        ]);
    }
}
