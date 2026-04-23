{{-- resources/views/detail-tutorial/edit.blade.php --}}
@extends('layouts.dashboard_layout')

@section('content')

<div class="max-w-2xl mx-auto py-8 px-4">

    {{-- Page header --}}
    <div class="mb-8">
        <p class="text-sm text-gray-400 mb-1">{{ $master->judul }} · Langkah ke-{{ $detail->order }}</p>
        <h1 class="text-2xl font-bold text-white">Edit Detail Tutorial</h1>
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

            <form method="POST"
                  action="/master/{{ $master->id }}/detail/{{ $detail->id }}/update"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                {{-- ── Tipe Konten (dropdown) ───────────────────────────────── --}}
                <div>
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-200">
                        Tipe Konten <span class="text-red-400">*</span>
                    </label>
                    <select id="type" name="type"
                            onchange="switchType(this.value)"
                            class="w-full border border-slate-600 bg-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100
                                   focus:outline-none focus:border-[#408A71] focus:ring-2 focus:ring-[#285A48]/50
                                   transition-all duration-200 cursor-pointer">
                        <option value="text"   {{ old('type', $detail->type) === 'text'   ? 'selected' : '' }}>📝 Text</option>
                        <option value="gambar" {{ old('type', $detail->type) === 'gambar' ? 'selected' : '' }}>🖼 Gambar</option>
                        <option value="code"   {{ old('type', $detail->type) === 'code'   ? 'selected' : '' }}>💻 Code</option>
                        <option value="url"    {{ old('type', $detail->type) === 'url'    ? 'selected' : '' }}>🔗 URL</option>
                    </select>
                    <p class="text-xs text-amber-400 mt-2">
                        ⚠ Mengubah tipe akan menghapus konten lama dari tipe sebelumnya.
                    </p>
                </div>

                {{-- ── Field: Text ──────────────────────────────────────────── --}}
                <div id="field-text" class="content-field">
                    <label class="block mb-2 text-sm font-medium text-gray-200">
                        Teks <span class="text-red-400">*</span>
                    </label>
                    <textarea name="text" rows="4"
                              placeholder="Masukkan teks penjelasan langkah..."
                              class="w-full border border-slate-600 bg-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100 placeholder-slate-400
                                     focus:outline-none focus:border-[#408A71] focus:ring-2 focus:ring-[#285A48]/50
                                     transition-all duration-200 resize-y @error('text') border-red-400 @enderror">{{ old('text', $detail->text) }}</textarea>
                    @error('text')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Field: Gambar ────────────────────────────────────────── --}}
                <div id="field-gambar" class="content-field hidden">
                    <label class="block mb-2 text-sm font-medium text-gray-200">
                        Gambar
                        @if($detail->type === 'gambar' && $detail->gambar)
                            <span class="text-xs text-gray-400 font-normal ml-1">(kosongkan jika tidak ingin mengubah)</span>
                        @else
                            <span class="text-red-400">*</span>
                        @endif
                    </label>

                    {{-- Preview gambar saat ini --}}
                    @if($detail->type === 'gambar' && $detail->gambar)
                    <div class="flex items-center gap-3 p-3 bg-gray-700 rounded-xl border border-gray-600 mb-3">
                        <img src="{{ Storage::url($detail->gambar) }}" alt="Gambar saat ini"
                             class="w-16 h-16 object-cover rounded-lg border border-gray-500">
                        <div>
                            <p class="text-xs font-medium text-gray-300">Gambar saat ini:</p>
                            <p class="text-xs text-gray-400 break-all">{{ basename($detail->gambar) }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-600 hover:border-[#408A71] rounded-xl p-8 text-center cursor-pointer transition-all duration-200"
                         onclick="document.getElementById('gambar-input').click()">
                        <svg class="w-8 h-8 text-gray-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-400">Klik untuk pilih gambar baru</p>
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF, WEBP — Maks 2MB</p>
                    </div>
                    <input id="gambar-input" type="file" name="gambar" accept="image/*"
                           class="hidden" onchange="previewImage(event)">
                    <img id="gambar-preview" src="#" alt="Preview"
                         class="hidden mt-3 max-h-48 rounded-xl border border-gray-600 object-contain">
                    @error('gambar')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Field: Code ──────────────────────────────────────────── --}}
                <div id="field-code" class="content-field hidden space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-200">
                            Bahasa Pemrograman <span class="text-red-400">*</span>
                        </label>
                        <select name="language"
                                class="w-full border border-slate-600 bg-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100
                                       focus:outline-none focus:border-[#408A71] focus:ring-2 focus:ring-[#285A48]/50
                                       transition-all duration-200 cursor-pointer @error('language') border-red-400 @enderror">
                            @foreach(['php','javascript','python','html','css','java','csharp','cpp','sql','bash','json','typescript','go','rust'] as $lang)
                            <option value="{{ $lang }}"
                                {{ old('language', $detail->getParsedCodeAttribute()['language'] ?? '') === $lang ? 'selected' : '' }}>
                                {{ strtoupper($lang) }}
                            </option>
                            @endforeach
                        </select>
                        @error('language')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-200">
                            Source Code <span class="text-red-400">*</span>
                        </label>
                        <textarea name="code" rows="8"
                                  class="w-full border border-slate-600 bg-slate-900 rounded-xl px-4 py-3 text-sm font-mono text-green-300 placeholder-slate-500
                                         focus:outline-none focus:border-[#408A71] focus:ring-2 focus:ring-[#285A48]/50
                                         transition-all duration-200 resize-y @error('code') border-red-400 @enderror">{{ old('code', $detail->getParsedCodeAttribute()['code'] ?? '') }}</textarea>
                        @error('code')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ── Field: URL ───────────────────────────────────────────── --}}
                <div id="field-url" class="content-field hidden">
                    <label class="block mb-2 text-sm font-medium text-gray-200">
                        URL <span class="text-red-400">*</span>
                    </label>
                    <input type="url" name="url" value="{{ old('url', $detail->url) }}"
                           placeholder="https://contoh.com/halaman"
                           class="w-full border border-slate-600 bg-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100 placeholder-slate-400
                                  focus:outline-none focus:border-[#408A71] focus:ring-2 focus:ring-[#285A48]/50
                                  transition-all duration-200 @error('url') border-red-400 @enderror">
                    @error('url')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Order & Status ───────────────────────────────────────── --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-200">
                            Urutan (Order) <span class="text-red-400">*</span>
                        </label>
                        <input type="number" name="order" value="{{ old('order', $detail->order) }}" min="1"
                               class="w-full border border-slate-600 bg-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100
                                      focus:outline-none focus:border-[#408A71] focus:ring-2 focus:ring-[#285A48]/50
                                      transition-all duration-200 @error('order') border-red-400 @enderror">
                        @error('order')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-200">
                            Status <span class="text-red-400">*</span>
                        </label>
                        <select name="status"
                                class="w-full border border-slate-600 bg-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100
                                       focus:outline-none focus:border-[#408A71] focus:ring-2 focus:ring-[#285A48]/50
                                       transition-all duration-200 cursor-pointer">
                            <option value="show" {{ old('status', $detail->status) === 'show' ? 'selected' : '' }}>👁 Show</option>
                            <option value="hide" {{ old('status', $detail->status) === 'hide' ? 'selected' : '' }}>🙈 Hide</option>
                        </select>
                    </div>
                </div>

                {{-- ── Footer Actions ───────────────────────────────────────── --}}
                <div class="flex items-center justify-between pt-2">
                    <a href="/master/{{ $master->id }}/detail"
                       class="flex items-center gap-1.5 text-sm font-medium text-slate-400 hover:text-slate-200 transition-colors duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                        </svg>
                        Kembali
                    </a>

                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-[#285A48] hover:bg-[#408A71] active:scale-95
                                   text-white text-sm font-semibold px-6 py-3 rounded-xl
                                   focus:outline-none focus:ring-3 focus:ring-[#285A48]/50 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        Update Detail
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    function switchType(type) {
        document.querySelectorAll('.content-field').forEach(f => f.classList.add('hidden'));
        const target = document.getElementById('field-' + type);
        if (target) target.classList.remove('hidden');
    }

    // Init sesuai old value / nilai dari DB
    switchType('{{ old('type', $detail->type) }}');

    function previewImage(event) {
        const preview = document.getElementById('gambar-preview');
        const file    = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    }
</script>

@endsection