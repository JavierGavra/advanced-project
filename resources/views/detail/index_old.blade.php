@extends('layouts.dashboard_layout')
@section('content')
<div class="min-h-screen bg-gray-50 p-6">
 
    {{-- ── Header ─────────────────────────────────────────────────────────── --}}
    <div class="mb-6">
        <a href="/master"
           class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-3 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Master Tutorial
        </a>
 
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $master->judul }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    <span class="font-medium text-gray-600">Kode Matkul:</span> {{ $master->kode_matkul }}
                    &nbsp;·&nbsp;
                    <span class="font-medium text-gray-600">Creator:</span> {{ $master->creator_email }}
                </p>
            </div>
 
            <a href="/master/{{ $master->id }}/detail/create"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Detail
            </a>
        </div>
    </div>
 
    {{-- ── Flash Message ───────────────────────────────────────────────────── --}}
    @if(session('success'))
    <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
 
    @if(session('error'))
    <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif
 
    {{-- ── Tabel ───────────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($details->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-gray-400">
            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0120 9.414V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-sm font-medium">Belum ada detail tutorial</p>
            <p class="text-xs mt-1">Klik tombol "Tambah Detail" untuk mulai menambahkan langkah.</p>
        </div>
        @else
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 w-16">Order</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 w-28">Tipe</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Preview Konten</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600 w-28">Status</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600 w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($details as $detail)
                <tr class="hover:bg-gray-50 transition">
                    {{-- Order --}}
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50 text-indigo-700 font-bold text-sm">
                            {{ $detail->order }}
                        </span>
                    </td>
 
                    {{-- Tipe badge --}}
                    <td class="px-4 py-3">
                        @php $badge = $detail->getTypeBadge(); @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge['color'] }}">
                            @if($detail->type === 'text')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            @elseif($detail->type === 'gambar')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @elseif($detail->type === 'code')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            @elseif($detail->type === 'url')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            @endif
                            {{ $badge['label'] }}
                        </span>
                    </td>
 
                    {{-- Preview konten --}}
                    <td class="px-4 py-3 text-gray-700 max-w-sm">
                        @if($detail->type === 'gambar')
                            <div class="flex items-center gap-2">
                                <img src="{{ Storage::url($detail->gambar) }}"
                                     alt="preview"
                                     class="w-12 h-12 object-cover rounded-md border border-gray-200">
                                <span class="text-xs text-gray-500 truncate">{{ basename($detail->gambar) }}</span>
                            </div>
                        @elseif($detail->type === 'code')
                            <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded font-mono block truncate">
                                {{ $detail->content_preview }}
                            </code>
                        @elseif($detail->type === 'url')
                            <a href="{{ $detail->url }}" target="_blank"
                               class="text-indigo-600 hover:underline truncate block text-xs">
                                {{ $detail->url }}
                            </a>
                        @else
                            <span class="text-gray-700">{{ $detail->content_preview }}</span>
                        @endif
                    </td>
 
                    {{-- Status toggle --}}
                    <td class="px-4 py-3 text-center">
                        <form method="POST"
                              action="">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold transition cursor-pointer
                                        {{ $detail->status === 'show'
                                            ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                            : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                @if($detail->status === 'show')
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Show
                                @else
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/>
                                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.064 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>
                                    </svg>
                                    Hide
                                @endif
                            </button>
                        </form>
                    </td>
 
                    {{-- Aksi --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Edit --}}
                            <a href="/master/{{ $master->id }}/detail/{{ $detail->id }}/edit"
                               title="Edit"
                               class="p-1.5 rounded-lg text-indigo-600 hover:bg-indigo-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
 
                            {{-- Delete --}}
                            <form method="POST"
                                  action="/master/{{ $master->id }}/detail/{{ $detail->id }}"
                                  onsubmit="return confirm('Hapus detail tutorial ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus"
                                        class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
 
    {{-- ── Info URL ─────────────────────────────────────────────────────────── --}}
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="bg-white border border-gray-200 rounded-lg px-4 py-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">URL Presentation</p>
            <a href="{{ $master->url_presentation }}" target="_blank"
               class="text-indigo-600 text-sm hover:underline break-all">{{ $master->url_presentation }}</a>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg px-4 py-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">URL Finished (PDF)</p>
            <a href="{{ $master->url_finished }}" target="_blank"
               class="text-indigo-600 text-sm hover:underline break-all">{{ $master->url_finished }}</a>
        </div>
    </div>
 
</div>
@endsection