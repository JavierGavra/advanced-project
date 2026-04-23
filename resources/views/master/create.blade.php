@extends('layouts.dashboard_layout')
@section('content')

<div class="max-w-2xl mx-auto py-8 px-4">

    {{-- Page header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">Tambah Tutorial Baru</h1>
    </div>

    {{-- Card --}}
    <div class="bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-8">

            {{-- Error bag --}}
            @if($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 border border-red-100 px-4 py-3 flex gap-3">
                    <svg class="w-4 h-4 text-red-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    <ul class="text-sm text-red-600 space-y-0.5 list-none">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/master/store" class="space-y-6">
                @csrf

                {{-- Judul Tutorial --}}
                <div>
                    <label for="judul" class="block mb-2 text-sm font-medium text-gray-200 dark:text-white-300">
                        Judul Tutorial <span class="text-red-400">*</span>
                    </label>
                    <input
                        id="judul"
                        type="text"
                        name="judul"
                        value="{{ old('judul') }}"
                        placeholder="Contoh: Pengantar Algoritma dan Pemrograman"
                        required
                        class="w-full border-1.5 border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400
                               focus:outline-none focus:border-indigo-400 focus:bg-white focus:ring-3 focus:ring-indigo-100
                               transition-all duration-200"
                    >
                </div>

                {{-- Mata Kuliah --}}
                <div>
                    <label for="matkul" class="block mb-2 text-sm font-medium text-gray-200 dark:text-white-300">
                        Mata Kuliah <span class="text-red-400">*</span>
                    </label>
                    <select
                        id="matkul"
                        name="matkul"
                        required
                        class="w-full border-1.5 border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-800
                               focus:outline-none focus:border-indigo-400 focus:bg-white focus:ring-3 focus:ring-indigo-100
                               transition-all duration-200 cursor-pointer"
                    >
                        <option value="" disabled selected>Pilih mata kuliah...</option>
                        @if(isset($matkul) && is_array($matkul))
                            @foreach($matkul as $m)
                                <option value="{{ $m }}" {{ old('matkul') == $m ? 'selected' : '' }}>
                                    {{ $m }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                {{-- Footer actions --}}
                <div class="flex items-center justify-between pt-2">
                    <a href="javascript:history.back()"
                       class="flex items-center gap-1.5 text-sm font-medium text-slate-400 hover:text-slate-600 transition-colors duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                        </svg>
                        Kembali
                    </a>

                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-[#285A48] hover:bg-[#408A71] active:scale-95 
                            text-white text-sm font-semibold px-6 py-3 rounded-xl focus:outline-none focus:ring-3 focus:ring-indigo-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        Simpan Tutorial
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection