@extends('layouts.dashboard_layout')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white"><span class="text-[#408A71]">Manajemen</span> Master Tutorial</h1>
            <p class="text-sm text-slate-400 mt-0.5">{{ $tutorials->count() }} tutorial terdaftar</p>
        </div>
        <a href="/master/create"
            class="inline-flex items-center gap-2 bg-[#408A71] hover:bg-[#4fa382] active:scale-95
                  text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                  shadow-lg shadow-[#285A48]/40 transition-all duration-150 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Tutorial
        </a>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400
                    px-4 py-3 rounded-xl mb-6 text-sm font-medium">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Table card --}}
    <div class="bg-gray-800/60 border border-white/5 rounded-2xl overflow-hidden backdrop-blur-sm">

        {{-- Table header bar --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-[#408A71]/15 border border-[#408A71]/20
                                                flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-[#408A71]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-300">Daftar Tutorial</span>
            </div>
            <span class="text-xs text-slate-500 bg-white/5 px-2.5 py-1 rounded-full">
                Total: {{ $tutorials->count() }}
            </span>
        </div>

        @if($tutorials->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-slate-500">
            <svg class="w-12 h-12 mb-3 opacity-30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
            </svg>
            <p class="text-sm font-medium">Belum ada tutorial</p>
            <p class="text-xs mt-1">Klik tombol "Tambah Tutorial" untuk mulai.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-8">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode MK</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Presentation URL</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($tutorials as $i => $tutorial)
                    <tr class="group relative hover:bg-white/5 transition-colors duration-100 cursor-pointer" onclick="window.location='/master/{{ $tutorial->id }}/detail'">
                        {{-- No --}}
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-600 font-mono">{{ $i + 1 }}</span>
                        </td>

                        {{-- Judul --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-semibold text-slate-100">{{ $tutorial->judul }}</span>
                            </div>
                        </td>

                        {{-- Kode MK --}}
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-[#408A71]/10
                                             border border-[#408A71]/20 text-[#B0E4CC] text-xs font-semibold font-mono">
                                {{ $tutorial->kode_matkul }}
                            </span>
                        </td>

                        {{-- URL --}}
                        <td class="px-6 py-4 max-w-xs">
                            <a href="/{{ $tutorial->presentation_url }}" target="_blank" onclick="event.stopPropagation();"
                                class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-sky-400
                                          transition-colors duration-150 truncate max-w-48 group/link">
                                <svg class="w-3.5 h-3.5 shrink-0 text-slate-600 group-hover/link:text-sky-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                </svg>
                                /{{ $tutorial->presentation_url }}
                            </a>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                {{-- Edit --}}
                                <a href="/master/{{ $tutorial->id }}/edit"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                              text-slate-300 bg-white/5 hover:bg-white/10
                                              border border-white/5 hover:border-white/15
                                              transition-all duration-150">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                    </svg>
                                    Edit
                                </a>

                                {{-- Hapus --}}
                                <form action="/master/{{ $tutorial->id }}/delete" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button onclick="event.stopPropagation(); return confirm('Yakin ingin menghapus tutorial ini?')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                                       text-red-400 bg-red-500/5 hover:bg-red-500/15
                                                       border border-red-500/10 hover:border-red-500/25
                                                       transition-all duration-150">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </div>
</div>
@endsection