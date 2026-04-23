@extends('layouts.dashboard_layout')
@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">{{ $master->judul }}</h1>
            <p class="text-sm text-slate-400 mt-0.5">
                <span class="font-medium text-gray-600">Kode Matkul:</span> {{ $master->kode_matkul }}
                &nbsp;·&nbsp;
                <span class="font-medium text-gray-600">Creator:</span> {{ $master->creator_email }}
            </p>
        </div>
        <a href="/master/{{ $master->id }}/detail/create"
            class="inline-flex items-center gap-2 bg-[#408A71] hover:bg-[#4fa382] active:scale-95
                  text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                  shadow-lg shadow-[#285A48]/40 transition-all duration-150 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Detail
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
                <div class="w-8 h-8 rounded-lg bg-[#408A71]/15 border border-[#408A71]/20 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-[#408A71]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-300">Daftar Tutorial</span>
            </div>
            <span class="text-xs text-slate-500 bg-white/5 px-2.5 py-1 rounded-full">
                Total Detail : {{ $details->count() }}
            </span>
        </div>

        @if($details->isEmpty())
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
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase  w-16">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase  w-28">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase ">Preview Konten</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase  w-28">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase  w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($details as $detail)
                    <tr class="group relative hover:bg-white/5 transition-colors duration-100 cursor-pointer" onclick="window.location='/master/{{ $detail->master_tutorial_id }}/detail'">
                        {{-- No --}}
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-600 font-mono">{{ $detail->order }}</span>
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
                        <td class="px-6 py-4 text-gray-700 max-w-sm">
                            @if($detail->type === 'gambar')
                                <div class="flex items-center gap-2">
                                    <img src="{{ Storage::url($detail->gambar) }}"
                                        alt="preview"
                                        class="w-12 h-12 object-cover rounded-md border border-gray-200">
                                    <span class="text-xs text-gray-500 truncate">{{ $detail->getContentPreview() }}</span>
                                </div>
                            @elseif($detail->type === 'code')
                                <code class="text-xs bg-slate-900 text-green-300 px-2 py-1 rounded font-mono block truncate">
                                    {{ $detail->getContentPreview() }}
                                </code>
                            @elseif($detail->type === 'url')
                                <a href="{{ $detail->url }}" target="_blank"
                                class="text-indigo-600 hover:underline truncate block text-xs">
                                    {{ $detail->getContentPreview() }}
                                </a>
                            @else
                            <span class="text-gray-700">{{ $detail->getContentPreview() }}</span>
                            @endif
                        </td>

                        {{-- Status toggle --}}
                        <td class="px-4 py-3 text-center">
                            <form method="POST" action="{{ route('detail.toggleStatus', ['master' => $master->id, 'detail' => $detail->id]) }}">
                                @csrf
                                <button type="submit"
                                        onclick="event.stopPropagation();"
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
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                {{-- Edit --}}
                                <a href="/master/{{ $master->id }}/detail/{{ $detail->id }}/edit"
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
                                <form action="/master/{{ $master->id }}/detail/{{ $detail->id }}/delete" method="POST" class="inline">
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