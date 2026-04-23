<?php

namespace App\Http\Controllers;

use App\Models\MasterTutorial;
use App\Services\ExternalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MasterTutorialController extends Controller
{
    protected $externalService;

    public function __construct(ExternalService $externalService)
    {
        $this->externalService = $externalService;
    }

    public function index()
    {
        $tutorials = MasterTutorial::with('details')->latest()->get();
        return view('master.index', compact('tutorials'));
    }

    public function show(MasterTutorial $master)
    {
        $tutorial = $master->details();
        return view('master.detail', compact('master', 'tutorial'));
    }

    public function create()
    {
        $matkul = $this->externalService->getMakul();

        if ($matkul == []) {
            return redirect("/login")
                ->with('error', 'Sesi anda telah habis. Silakan login kembali.');
        }

        return view('master.create', [
            'matkul' => $matkul
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'matkul' => 'required|string',
        ]);

        $parts = explode(" - ", $request->matkul);

        $kode_matkul = $parts[0];
        $nama_matkul = $parts[1];

        $slug = Str::slug($request->judul);
        $pRandom = Str::random(16);
        $fRandom = Str::random(16);

        MasterTutorial::create([
            'judul'            => $request['judul'],
            'nama_matkul'      => $nama_matkul,
            'kode_matkul'      => $kode_matkul,
            'presentation_url' => "presentation/{$slug}-{$pRandom}",
            'finished_url'     => "finished/{$slug}-{$fRandom}",
            'creator_email'    => session('user_email'),
        ]);

        return redirect('/master')
            ->with('success', 'Master tutorial berhasil dibuat.');
    }

    public function edit(MasterTutorial $master)
    {
        $matkul = $this->externalService->getMakul();
        if (!$matkul) {
            return redirect("/login")
                ->with('error', 'Sesi anda telah habis. Silakan login kembali.');
        }
        return view('master.edit', [
            'master' => $master,
            'matkul' => $matkul
        ]);
    }

    public function update(Request $request, MasterTutorial $master)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'matkul' => 'required|string',
        ]);

        $parts = explode(" - ", $request->matkul);

        $kode_matkul = $parts[0];
        $nama_matkul = $parts[1];

        $master->update([
            'judul'            => $request->judul,
            'kode_matkul'      => $kode_matkul,
            'nama_matkul'      => $nama_matkul,
        ]);

        return redirect('/master')
            ->with('success', 'Master tutorial berhasil diupdate.');
    }

    public function destroy(MasterTutorial $master)
    {
        $master->delete();
        return redirect('/master')
            ->with('success', 'Master tutorial berhasil dihapus.');
    }
}
