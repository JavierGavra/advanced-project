<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $master->judul }}</title>
    <style>
        /* ── Reset & Base ─────────────────────────────────────── */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.7;
            color: #1e293b;
            background: #ffffff;
        }

        /* ── Header ───────────────────────────────────────────── */
        .header {
            background: #1a3329;
            color: #ffffff;
            padding: 28px 32px;
            margin-bottom: 0;
        }

        .header-kode {
            font-size: 10px;
            color: #6fcca8;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .header-judul {
            font-size: 20px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .header-meta {
            font-size: 10px;
            color: #94a3b8;
        }

        .header-meta span {
            margin-right: 16px;
        }

        /* ── Divider ──────────────────────────────────────────── */
        .divider {
            height: 4px;
            background: #285A48;
            margin-bottom: 32px;
        }

        /* ── Content wrapper ──────────────────────────────────── */
        .content {
            padding: 0 32px 32px 32px;
        }

        /* ── Step ─────────────────────────────────────────────── */
        .step {
            margin-bottom: 28px;
            page-break-inside: avoid;
        }

        .step-header {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .step-number {
            display: table-cell;
            width: 32px;
            vertical-align: top;
        }

        .step-number-badge {
            width: 26px;
            height: 26px;
            background: #285A48;
            color: #ffffff;
            border-radius: 50%;
            text-align: center;
            line-height: 26px;
            font-size: 11px;
            font-weight: bold;
        }

        .step-body {
            display: table-cell;
            vertical-align: top;
            padding-left: 10px;
        }

        /* ── Tipe: text ───────────────────────────────────────── */
        .content-text {
            font-size: 12px;
            color: #334155;
            line-height: 1.8;
            white-space: pre-wrap;
            word-break: break-word;
        }

        /* ── Tipe: gambar ─────────────────────────────────────── */
        .content-image {
            max-width: 100%;
            max-height: 340px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        /* ── Tipe: code ───────────────────────────────────────── */
        .code-wrapper {
            background: #0f172a;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #1e293b;
        }

        .code-header {
            background: #1e293b;
            padding: 6px 14px;
            display: table;
            width: 100%;
        }

        .code-lang {
            display: table-cell;
            font-size: 9px;
            color: #6fcca8;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            vertical-align: middle;
        }

        .code-dots {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
            font-size: 18px;
            line-height: 1;
            letter-spacing: 4px;
            color: #475569;
        }

        .code-body {
            padding: 14px;
            font-family: 'DejaVu Sans Mono', 'Courier New', monospace;
            font-size: 10.5px;
            color: #e2e8f0;
            white-space: pre-wrap;
            word-break: break-all;
            line-height: 1.7;
        }

        /* ── Tipe: url ────────────────────────────────────────── */
        .content-url {
            display: inline-block;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            padding: 8px 14px;
            font-size: 11px;
            color: #166534;
            word-break: break-all;
        }

        /* ── Status badge (untuk detail hide) ────────────────── */
        .status-hide {
            display: inline-block;
            font-size: 9px;
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            border-radius: 4px;
            padding: 2px 7px;
            margin-bottom: 6px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        /* ── Separator antar step ─────────────────────────────── */
        .step-separator {
            border: none;
            border-top: 1px dashed #e2e8f0;
            margin: 20px 0 20px 42px;
        }

        /* ── Footer ───────────────────────────────────────────── */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 32px;
            border-top: 1px solid #e2e8f0;
            font-size: 9px;
            color: #94a3b8;
            background: #fff;
            display: table;
            width: 100%;
        }

        .footer-left  { display: table-cell; text-align: left; }
        .footer-right { display: table-cell; text-align: right; }
    </style>
</head>
<body>

    {{-- ── Header ─────────────────────────────────────────────────────── --}}
    <div class="header">
        <div class="header-kode">{{ $master->kode_matkul }}</div>
        <div class="header-judul">{{ $master->judul }}</div>
        <div class="header-meta">
            <span>👤 {{ $master->creator_email }}</span>
            <span>📅 {{ $master->created_at->format('d M Y') }}</span>
            <span>📄 {{ $details->count() }} langkah</span>
        </div>
    </div>
    <div class="divider"></div>

    {{-- ── Footer (fixed, muncul di setiap halaman) ────────────────────── --}}
    <div class="footer">
        <div class="footer-left">{{ $master->judul }}</div>
        <div class="footer-right">{{ $master->creator_email }} &nbsp;·&nbsp; Dicetak {{ now()->format('d M Y, H:i') }}</div>
    </div>

    {{-- ── Content ──────────────────────────────────────────────────────── --}}
    <div class="content">

        @forelse($details as $detail)
        <div class="step">

            <div class="step-header">
                {{-- Konten --}}
                <div class="step-body">
                    @if($detail->type === 'text')
                        {{-- ── TEXT ── --}}
                        <div class="content-text">{{ $detail->text }}</div>

                    @elseif($detail->type === 'gambar')
                        {{-- ── GAMBAR ── --}}
                        @if(isset($detail->gambar_base64))
                            <img src="{{ $detail->gambar_base64 }}"
                                 alt="Langkah {{ $detail->order }}"
                                 class="content-image">
                        @else
                            <span style="color:#94a3b8;font-size:11px;">[Gambar tidak tersedia]</span>
                        @endif

                    @elseif($detail->type === 'code')
                        {{-- ── CODE ── --}}
                        @php $parsed = $detail->parsed ?? ['language' => 'code', 'code' => $detail->code]; @endphp
                        <div class="code-wrapper">
                            <div class="code-header">
                                <span class="code-lang">{{ $parsed['language'] }}</span>
                                <span class="code-dots">· · ·</span>
                            </div>
                            <div class="code-body">{{ $parsed['code'] }}</div>
                        </div>

                    @elseif($detail->type === 'url')
                        {{-- ── URL ── --}}
                        <div class="content-url">🔗 {{ $detail->url }}</div>

                    @endif
                </div>
            </div>

        </div>

        @if(!$loop->last)
            <hr class="step-separator">
        @endif

        @empty
        <p style="color:#94a3b8;text-align:center;padding:40px 0;">Tidak ada detail tutorial.</p>
        @endforelse

    </div>

</body>
</html>