@extends('layouts.app')

@section('content')

{{-- ===== HEADER ===== --}}
<div style="margin-bottom: 2.5rem; position: relative;">
    <div style="position: absolute; width: 350px; height: 350px; background: radial-gradient(circle, rgba(239,68,68,0.12), transparent 70%); filter: blur(80px); top: -120px; left: -80px; z-index: -1;"></div>
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
        <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; box-shadow: 0 0 20px rgba(239,68,68,0.3);">📹</div>
        <div>
            <h1 style="font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; margin: 0; background: linear-gradient(to right, #ffffff, #fca5a5); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Monitor CCTV</h1>
        </div>
    </div>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-left: 3.5rem;">
        Pengawasan Area RT 02 Sawit Panggunghardjo •
        <span id="live-clock" style="color: #ef4444; font-weight: 700;"></span>
    </p>
</div>

{{-- ===== STATUS BAR ===== --}}
@php
    $online  = collect($cameras)->where('status', 'online')->count();
    $offline = collect($cameras)->where('status', 'offline')->count();
@endphp
<div style="display: flex; gap: 1.25rem; margin-bottom: 2rem; flex-wrap: wrap;">
    <div class="card" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.85rem 1.4rem; flex: 0 0 auto; border-left: 3px solid #ef4444;">
        <div style="width: 10px; height: 10px; background: #ef4444; border-radius: 50%; box-shadow: 0 0 8px #ef4444; animation: pulseRed 1.5s infinite;"></div>
        <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">LIVE</span>
        <span style="font-size: 1.1rem; font-weight: 800; color: var(--text);">{{ count($cameras) }} Kamera</span>
    </div>
    <div class="card" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 1.4rem; flex: 0 0 auto; border-left: 3px solid #10b981;">
        <span style="color: #10b981; font-size: 1.1rem;">✅</span>
        <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">Online</span>
        <span style="font-size: 1.1rem; font-weight: 800; color: #10b981;">{{ $online }}</span>
    </div>
    <div class="card" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 1.4rem; flex: 0 0 auto; border-left: 3px solid #f43f5e;">
        <span style="color: #f43f5e; font-size: 1.1rem;">⛔</span>
        <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">Offline</span>
        <span style="font-size: 1.1rem; font-weight: 800; color: #f43f5e;">{{ $offline }}</span>
    </div>
    <div style="margin-left: auto; display: flex; align-items: center; gap: 0.75rem;">
        <button onclick="setLayout(2)" id="btn-layout-2" class="layout-btn active-layout" title="2 Kolom">⊞</button>
        <button onclick="setLayout(3)" id="btn-layout-3" class="layout-btn" title="3 Kolom">⊟</button>
        <button onclick="setLayout(4)" id="btn-layout-4" class="layout-btn" title="4 Kolom">⊠</button>
    </div>
</div>

{{-- ===== GRID KAMERA ===== --}}
<div id="cctv-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
    @foreach($cameras as $cam)
    <div class="card cctv-card" style="padding: 0; overflow: hidden; position: relative; border: 1px solid {{ $cam['status'] === 'online' ? 'rgba(16,185,129,0.25)' : 'rgba(244,63,94,0.2)' }}; transition: all 0.3s ease;">

        {{-- Header Kamera --}}
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.85rem 1.1rem; background: rgba(255,255,255,0.03); border-bottom: 1px solid var(--border);">
            <div style="display: flex; align-items: center; gap: 0.65rem;">
                <span style="font-size: 1.1rem;">{{ $cam['icon'] }}</span>
                <div>
                    <div style="font-weight: 700; font-size: 0.88rem;">{{ $cam['nama'] }}</div>
                    <div style="font-size: 0.72rem; color: var(--text-muted);">📍 {{ $cam['lokasi'] }}</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: {{ $cam['status'] === 'online' ? '#10b981' : '#f43f5e' }};">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $cam['status'] === 'online' ? '#10b981' : '#f43f5e' }}; {{ $cam['status'] === 'online' ? 'animation: pulseGreen 1.8s infinite; box-shadow: 0 0 6px #10b981;' : '' }}"></span>
                {{ strtoupper($cam['status']) }}
            </div>
        </div>

        {{-- Area Tampilan Video / Placeholder --}}
        <div style="position: relative; aspect-ratio: 16/9; background: #060b14; overflow: hidden;">
            @if($cam['stream'])
                {{-- Jika ada URL stream MJPEG / HLS --}}
                <img src="{{ $cam['stream'] }}" style="width: 100%; height: 100%; object-fit: cover;"
                     onerror="this.style.display='none'; document.getElementById('placeholder-{{ $cam['id'] }}').style.display='flex';">
            @endif

            {{-- Placeholder saat tidak ada stream / offline --}}
            <div id="placeholder-{{ $cam['id'] }}" style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%; height: 100%; gap: 1rem; {{ $cam['stream'] ? 'display:none;' : '' }}">

                @if($cam['status'] === 'online')
                    {{-- Animasi sinyal CCTV online --}}
                    <div style="position: relative;">
                        <div style="font-size: 3.5rem; opacity: 0.15;">📹</div>
                        <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 4px;">
                            <div style="width: 40px; height: 2px; background: linear-gradient(90deg, transparent, #10b981, transparent); animation: scanline 2s infinite;"></div>
                        </div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 0.78rem; color: #10b981; font-weight: 700; letter-spacing: 1px;">SINYAL AKTIF</div>
                        <div style="font-size: 0.68rem; color: var(--text-muted); margin-top: 0.3rem;">Konfigurasi URL stream di CctvController</div>
                    </div>
                    {{-- Simulasi noise/scan lines --}}
                    <div style="position: absolute; inset: 0; background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(16,185,129,0.015) 2px, rgba(16,185,129,0.015) 4px); pointer-events: none;"></div>
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent, rgba(16,185,129,0.6), transparent); animation: scanDown 3s linear infinite;"></div>
                @else
                    {{-- Offline --}}
                    <div style="font-size: 3rem; opacity: 0.2;">📵</div>
                    <div style="text-align: center;">
                        <div style="font-size: 0.78rem; color: #f43f5e; font-weight: 700; letter-spacing: 1px;">SINYAL TERPUTUS</div>
                        <div style="font-size: 0.68rem; color: var(--text-muted); margin-top: 0.3rem;">Kamera tidak dapat dijangkau</div>
                    </div>
                    <div style="position: absolute; inset: 0; background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(244,63,94,0.03) 3px, rgba(244,63,94,0.03) 6px); pointer-events: none;"></div>
                @endif
            </div>

            {{-- Overlay info sudut kiri bawah --}}
            <div style="position: absolute; bottom: 0.6rem; left: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                <span class="cctv-badge" style="background: rgba(0,0,0,0.7); border: 1px solid rgba(255,255,255,0.1); padding: 0.25rem 0.6rem; border-radius: 6px; font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px; color: #fff;">
                    CAM {{ str_pad($cam['id'], 2, '0', STR_PAD_LEFT) }}
                </span>
                @if($cam['status'] === 'online')
                <span class="cctv-badge" style="background: rgba(239,68,68,0.85); padding: 0.25rem 0.6rem; border-radius: 6px; font-size: 0.65rem; font-weight: 800; letter-spacing: 1px; color: #fff; animation: blinkRec 1s step-end infinite;">⏺ REC</span>
                @endif
            </div>

            {{-- Timestamp pojok kanan bawah --}}
            <div style="position: absolute; bottom: 0.6rem; right: 0.75rem; font-size: 0.65rem; font-weight: 700; color: rgba(255,255,255,0.5); letter-spacing: 0.5px; font-family: monospace;">
                <span class="cam-time">{{ now()->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>

    </div>
    @endforeach
</div>

{{-- ===== CATATAN KONFIGURASI ===== --}}
<div class="card" style="border-left: 3px solid #f59e0b; padding: 1.25rem 1.5rem; display: flex; gap: 1rem; align-items: flex-start; margin-bottom: 3rem;">
    <span style="font-size: 1.5rem; flex-shrink: 0;">💡</span>
    <div>
        <div style="font-weight: 700; font-size: 0.9rem; color: #f59e0b; margin-bottom: 0.4rem;">Cara Menghubungkan Kamera CCTV</div>
        <div style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.7;">
            Buka file <code style="background: rgba(255,255,255,0.08); padding: 0.1rem 0.4rem; border-radius: 4px; font-size: 0.78rem;">app/Http/Controllers/CctvController.php</code>
            dan isi kolom <code style="background: rgba(255,255,255,0.08); padding: 0.1rem 0.4rem; border-radius: 4px; font-size: 0.78rem;">'stream'</code> dengan URL stream kamera Anda.<br>
            Contoh: <code style="background: rgba(255,255,255,0.08); padding: 0.1rem 0.4rem; border-radius: 4px; font-size: 0.78rem;">'stream' => 'http://192.168.1.101/video'</code> (MJPEG)
            atau embed iframe HLS dari NVR berbasis web.
        </div>
    </div>
</div>

<style>
    @keyframes pulseRed {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(1.3); }
    }
    @keyframes pulseGreen {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(1.3); }
    }
    @keyframes scanDown {
        0%   { top: 0%; }
        100% { top: 100%; }
    }
    @keyframes scanline {
        0%   { opacity: 0.3; transform: scaleX(0.5); }
        50%  { opacity: 1;   transform: scaleX(1.2); }
        100% { opacity: 0.3; transform: scaleX(0.5); }
    }
    @keyframes blinkRec {
        0%, 100% { opacity: 1; }
        50%       { opacity: 0; }
    }
    .cctv-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.4);
    }
    .layout-btn {
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text-muted);
        width: 36px; height: 36px;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex; align-items: center; justify-content: center;
    }
    .layout-btn:hover, .active-layout {
        background: rgba(99,102,241,0.15);
        border-color: var(--primary);
        color: var(--primary);
    }
</style>

<script>
    // Jam live
    function updateClock() {
        const now = new Date();
        document.getElementById('live-clock').textContent =
            now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }) +
            ' • ' + now.toLocaleTimeString('id-ID');
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Update timestamp tiap kamera
    function updateCamTimes() {
        const t = new Date().toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', day: '2-digit', month: '2-digit', year: 'numeric' }).replace(',', '');
        document.querySelectorAll('.cam-time').forEach(el => el.textContent = t);
    }
    setInterval(updateCamTimes, 1000);

    // Ganti layout grid
    function setLayout(cols) {
        const grid = document.getElementById('cctv-grid');
        grid.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;
        document.querySelectorAll('.layout-btn').forEach(b => b.classList.remove('active-layout'));
        document.getElementById('btn-layout-' + cols).classList.add('active-layout');
    }
</script>
@endsection
