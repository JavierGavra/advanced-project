{{-- resources/views/presentation/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $master->judul }}</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Prism.js Syntax Highlighter --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js" defer></script>

    <style>
        /* Override Prism agar radius konsisten */
        pre[class*="language-"] {
            border-radius: 0.75rem;
            margin: 0;
        }
        code[class*="language-"] {
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen">

    {{-- ── Top Bar ────────────────────────────────────────────────────────── --}}
    <header class="sticky top-0 z-50 bg-gray-900/80 backdrop-blur border-b border-gray-800">
        <div class="max-w-3xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-base font-bold text-white truncate">{{ $master->judul }}</h1>
                <p class="text-xs text-gray-400 mt-0.5">{{ $master->kode_matkul }}</p>
            </div>

            {{-- Live indicator --}}
            <div id="live-badge"
                 class="shrink-0 flex items-center gap-1.5 bg-green-500/10 border border-green-500/30 text-green-400 text-xs font-semibold px-3 py-1.5 rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                LIVE
            </div>
        </div>
    </header>

    {{-- ── Content ─────────────────────────────────────────────────────────── --}}
    <main class="max-w-3xl mx-auto px-6 py-10" id="tutorial-content">

        @if($details->isEmpty())
        {{-- Empty state --}}
        <div class="flex flex-col items-center justify-center py-24 text-gray-600">
            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
            </svg>
            <p class="text-lg font-semibold text-gray-500">Menunggu langkah pertama...</p>
            <p class="text-sm text-gray-600 mt-1">Halaman ini akan otomatis memperbarui saat langkah baru ditampilkan.</p>
        </div>
        @else
        <div class="space-y-6">
            @foreach($details as $detail)
            <div class="group flex gap-5">
                {{-- Konten --}}
                <div class="flex-1 pb-6 min-w-0">
                    @if($detail->type === 'text')
                        {{-- ── TEXT ── --}}
                        <p class="text-gray-200 leading-relaxed whitespace-pre-line">{{ $detail->text }}</p>

                    @elseif($detail->type === 'gambar')
                        {{-- ── GAMBAR ── --}}
                        <div class="rounded-xl overflow-hidden border border-gray-800 inline-block max-w-full">
                            <img src="{{ Storage::url($detail->gambar) }}"
                                 alt="Langkah {{ $detail->order }}"
                                 class="max-w-full max-h-[480px] object-contain bg-gray-900">
                        </div>

                    @elseif($detail->type === 'code')
                        {{-- ── CODE ── --}}
                        @php $parsed = $detail->parsed_code; @endphp
                        <div class="relative group/code">
                            {{-- Copy button --}}
                            <button onclick="copyCode(this)"
                                    class="absolute top-3 right-3 z-10 flex items-center gap-1.5 bg-gray-700 hover:bg-gray-600 text-gray-300 hover:text-white text-xs font-medium px-2.5 py-1.5 rounded-lg transition opacity-0 group-hover/code:opacity-100">
                                <svg class="w-3.5 h-3.5 copy-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span class="copy-label">Salin</span>
                            </button>

                            {{-- Language badge --}}
                            <div class="flex items-center justify-between bg-gray-800 rounded-t-xl px-4 py-2 border border-b-0 border-gray-700">
                                <span class="text-xs font-semibold text-[#6fcca8] uppercase tracking-wide">
                                    {{ $parsed['language'] }}
                                </span>
                                <div class="flex gap-1.5">
                                    <span class="w-3 h-3 rounded-full bg-red-500/60"></span>
                                    <span class="w-3 h-3 rounded-full bg-yellow-500/60"></span>
                                    <span class="w-3 h-3 rounded-full bg-green-500/60"></span>
                                </div>
                            </div>

                            <pre class="!rounded-t-none !rounded-b-xl border border-t-0 border-gray-700 overflow-x-auto"><code class="language-{{ $parsed['language'] }}">{{ $parsed['code'] }}</code></pre>
                        </div>

                    @elseif($detail->type === 'url')
                        {{-- ── URL ── --}}
                        <a href="{{ $detail->url }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-700 border border-gray-700 hover:border-[#408A71]
                                  text-[#6fcca8] text-sm font-medium px-4 py-3 rounded-xl transition-all duration-200 break-all group/link">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            {{ $detail->url }}
                            <svg class="w-3.5 h-3.5 shrink-0 ml-auto opacity-0 group-hover/link:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @endif
                </div>

            </div>
            @endforeach
        </div>
        @endif

    </main>

    {{-- ── Footer ──────────────────────────────────────────────────────────── --}}
    <footer class="max-w-3xl mx-auto px-6 pb-10 mt-4">
        <div class="border-t border-gray-800 pt-6 flex items-center justify-between text-xs text-gray-600">
            <span>{{ $master->creator_email }}</span>
            <span id="last-updated">Diperbarui: {{ now()->format('H:i:s') }}</span>
        </div>
    </footer>

    {{-- ── Auto-Refresh Script ─────────────────────────────────────────────── --}}
    <script>
        const POLL_URL   = "/{{ $master->presentation_url }}/poll";
        const POLL_MS    = 5000; // cek setiap 5 detik
        let   currentHash = null;

        async function checkForUpdates() {
            try {
                const res  = await fetch(POLL_URL, { cache: 'no-store' });
                const data = await res.json();

                if (currentHash === null) {
                    // Simpan hash awal
                    currentHash = data.hash;
                    return;
                }

                if (data.hash !== currentHash) {
                    // Ada perubahan → reload halaman
                    window.location.reload();
                }
            } catch (e) {
                // Diam saja jika gagal (misal offline sebentar)
            }
        }

        // Mulai polling
        checkForUpdates();
        setInterval(checkForUpdates, POLL_MS);

        // ── Copy code ───────────────────────────────────────────────────────
        function copyCode(btn) {
            const code = btn.closest('.group\\/code').querySelector('code');
            navigator.clipboard.writeText(code.innerText).then(() => {
                const label = btn.querySelector('.copy-label');
                const icon  = btn.querySelector('.copy-icon');
                label.textContent = 'Tersalin!';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
                setTimeout(() => {
                    label.textContent = 'Salin';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>';
                }, 2000);
            });
        }
    </script>

</body>
</html>