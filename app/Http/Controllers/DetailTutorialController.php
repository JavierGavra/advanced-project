<?php

namespace App\Http\Controllers;

use App\Models\DetailTutorial;
use App\Models\MasterTutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailTutorialController extends Controller {
    public function index(MasterTutorial $master) {
        $details = $master->details()
            ->orderBy('order')
            ->get();

        return view('detail.index', [
            'master' => $master,
            'details' => $details
        ]);
    }

    public function create(MasterTutorial $master) {
        $nextOrder = ($master->details()->max('order') ?? 0) + 1;

        return view('detail.create', [
            'master' => $master,
            'nextOrder' => $nextOrder
        ]);
    }

    public function store(Request $request, MasterTutorial $master) {
        $request->validate([
            'type'   => 'required|in:text,gambar,code,url',
            'order'  => 'required|integer|min:1',
            'status' => 'required|in:show,hide',
        ]);

        // Validasi per tipe
        match ($request->type) {
            'text'   => $request->validate(['text' => 'required|string']),
            'gambar' => $request->validate(['gambar' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048']),
            'code'   => $request->validate(['code' => 'required|string']),
            'url'    => $request->validate(['url' => 'required|url']),
        };

        $data = [
            'master_tutorial_id' => $master->id,
            'type'               => $request->type,
            'order'              => $request->order,
            'status'             => $request->status,
        ];

        // Isi data sesuai tipe
        switch ($request->type) {
            case 'text':
                $data['text'] = $request->text;
                break;

            case 'gambar':
                $data['gambar'] = $request->file('gambar')->store('detail-images', 'public');
                break;

            case 'code':
                $data['code']     = DetailTutorial::buildCodeField($request->language, $request->code);
                break;

            case 'url':
                $data['url'] = $request->url;
                break;
        }

        DetailTutorial::create($data);

        return redirect('/master/' . $master->id . '/detail')
            ->with('success', 'Detail tutorial berhasil ditambahkan!');
    }

    public function edit(MasterTutorial $master, DetailTutorial $detail) {
        return view('detail.edit', compact('master', 'detail'));
    }

    public function update(Request $request, MasterTutorial $master, DetailTutorial $detail) {
        $request->validate([
            'type'   => 'required|in:text,gambar,code,url',
            'order'  => 'required|integer|min:1',
            'status' => 'required|in:show,hide',
        ]);

        match ($request->type) {
            'text'   => $request->validate(['text' => 'required|string']),
            'gambar' => $request->validate(['gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048']),
            'code'   => $request->validate(['code' => 'required|string']),
            'url'    => $request->validate(['url' => 'required|url']),
        };

        // Reset semua field konten (clear lama)
        $data = [
            'type'     => $request->type,
            'order'    => $request->order,
            'status'   => $request->status,
            'text'     => null,
            'gambar'   => $detail->gambar, // default tetap path lama
            'code'     => null,
            'language' => null,
            'url'      => null,
        ];

        switch ($request->type) {
            case 'text':
                $data['text']   = $request->text;
                $data['gambar'] = $this->deleteOldImage($detail, null);
                break;

            case 'gambar':
                if ($request->hasFile('gambar')) {
                    // Hapus gambar lama jika ada
                    if ($detail->gambar) {
                        Storage::disk('public')->delete($detail->gambar);
                    }
                    $data['gambar'] = $request->file('gambar')->store('detail-images', 'public');
                }
                break;

            case 'code':
                $data['code']     = DetailTutorial::buildCodeField($request->language, $request->code);
                $data['gambar']   = $this->deleteOldImage($detail, null);
                break;

            case 'url':
                $data['url']    = $request->url;
                $data['gambar'] = $this->deleteOldImage($detail, null);
                break;
        }

        $detail->update($data);

        return redirect('/master/' . $master->id . '/detail')
            ->with('success', 'Detail tutorial berhasil diupdate!');
    }

    public function destroy(MasterTutorial $master, DetailTutorial $detail)
    {
        if ($detail->type === 'gambar' && $detail->gambar) {
            Storage::disk('public')->delete($detail->gambar);
        }

        $detail->delete();

        return back()->with('success', 'Detail tutorial berhasil dihapus!');
    }

    public function toggleStatus(MasterTutorial $master, DetailTutorial $detail) {
        $detail->status = $detail->status === 'show' ? 'hide' : 'show';
        $detail->save();

        return back()->with('success', 'Status berhasil diubah menjadi ' . $detail->status . '!');
    }
 
    // ─── PRIVATE HELPER ───────────────────────────────────────────────────────

    private function deleteOldImage(DetailTutorial $detail, $fallback): ?string
    {
        if ($detail->type === 'gambar' && $detail->gambar) {
            Storage::disk('public')->delete($detail->gambar);
        }
        return $fallback;
    }
}
