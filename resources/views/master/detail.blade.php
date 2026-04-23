@extends('layouts.dashboard_layout')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold">Detail Tutorial</h1>
            <p class="text-gray-600">{{ $master->judul }} ({{ $master->kode_matkul }})</p>
        </div>
        <a href="/master/{{ $master->id }}/details/create" 
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg">
            + Tambah Detail Baru
        </a>
    </div>

    <a href="/master" class="text-blue-600 hover:underline mb-4 inline-block">&larr; Kembali ke Master</a>

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Order</th>
                    <th class="px-6 py-3 text-left">Isi</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($tutorial as $detail)
                <tr>
                    <td class="px-6 py-4 font-medium">{{ $detail->order }}</td>
                    <td class="px-6 py-4">
                        @if($detail->text)
                            <span class="line-clamp-2">{{ Str::limit($detail->text, 100) }}</span>
                        @elseif($detail->gambar)
                            <img src="{{ Storage::url($detail->gambar) }}" alt="gambar" class="h-16 w-auto object-cover rounded">
                        @elseif($detail->code)
                            <code class="bg-gray-100 px-2 py-1 text-xs">Code Snippet</code>
                        @elseif($detail->url)
                            <a href="{{ $detail->url }}" target="_blank" class="text-blue-600">{{ $detail->url }}</a>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($detail->status === 'show')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Show</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Hide</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="/master/{{ $master->id }}/details/{{ $detail->id }}/edit" 
                           class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                        <form action="/master/{{ $master->id }}/details/{{ $detail->id }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Yakin hapus detail ini?')" 
                                    class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection