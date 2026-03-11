@extends('layouts.app')

@section('content')
{{-- ===== HEADER ===== --}}
<div style="margin-bottom: 3rem; position: relative;">
    <div style="position: absolute; width: 300px; height: 300px; background: var(--primary-glow); filter: blur(100px); top: -100px; left: -100px; z-index: -1;"></div>
    <h1 style="font-size: 2.8rem; font-weight: 800; letter-spacing: -1.5px; margin-bottom: 0.4rem; background: linear-gradient(to right, #ffffff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Dashboard Pengelolaan</h1>
    <p style="color: var(--text-muted); font-size: 1rem;">Sistem Informasi Warga Sawit RT 02 • <span style="color: var(--primary);">{{ date('l, d F Y') }}</span></p>
</div>

{{-- ===== TOP STATS GRID ===== --}}
<div class="grid-mobile-stack" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2.5rem;">

    {{-- Saldo Kas --}}
    <div class="card" style="grid-column: span 2; background: linear-gradient(145deg, rgba(99,102,241,0.15) 0%, rgba(15,23,42,0.9) 100%); border-top: 3px solid var(--primary); position: relative; overflow: visible;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">💼 Saldo Kas RT</div>
                <div style="font-size: 2.8rem; font-weight: 900; letter-spacing: -1px; margin: 0.5rem 0; background: linear-gradient(135deg, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    Rp {{ number_format($saldoKas, 0, ',', '.') }}
                </div>
                <div style="font-size: 0.75rem; color: var(--text-muted);">Total Pemasukan − Total Pengeluaran</div>
            </div>
            <div style="font-size: 2rem; opacity: 0.4;">🏦</div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border);">
            <div style="text-align:center;">
                <div style="font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">Jimpitan</div>
                <div style="color: var(--success); font-weight: 700; font-size: 0.9rem;">+{{ number_format($totalJimpitan, 0, ',', '.') }}</div>
            </div>
            <div style="text-align:center; border-left: 1px solid var(--border); border-right: 1px solid var(--border);">
                <div style="font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">Kas Masuk</div>
                <div style="color: #0ea5e9; font-weight: 700; font-size: 0.9rem;">+{{ number_format($totalKasMasuk, 0, ',', '.') }}</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">Kas Keluar</div>
                <div style="color: var(--danger); font-weight: 700; font-size: 0.9rem;">−{{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Populasi Warga --}}
    <div class="card stat-card-warga" style="border-top: 3px solid var(--primary);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <div style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">👥 Warga</div>
            <div style="font-size: 1.2rem; opacity: 0.4;">📋</div>
        </div>
        <div style="font-size: 2.5rem; font-weight: 900; letter-spacing: -1px;">{{ $totalWarga }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.5rem;">jiwa terdaftar</div>
        <div style="font-size: 0.8rem; margin-top: 0.75rem; color: var(--text-muted);">di <strong style="color: var(--text);">{{ $totalRumah }}</strong> unit rumah</div>
    </div>

    {{-- Total Pemasukan --}}
    <div class="card stat-card-pemasukan" style="border-top: 3px solid var(--success);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <div style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">📥 Total Masuk</div>
            <div style="font-size: 1.2rem; opacity: 0.4;">💹</div>
        </div>
        <div style="font-size: 1.6rem; font-weight: 900; letter-spacing: -0.5px; color: var(--success);">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">Jimpitan + Kas Masuk</div>
    </div>

</div>

{{-- ===== CHART ===== --}}
<div class="card" style="margin-bottom: 2.5rem; padding: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1.25rem; font-weight: 700;">Grafik Keuangan {{ date('Y') }}</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.25rem;">Perbandingan Iuran Jimpitan, Kas Masuk & Kas Keluar per Bulan</p>
        </div>
        <div style="display: flex; gap: 1.25rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: var(--text-muted);">
                <div style="width: 12px; height: 12px; border-radius: 3px; background: #10b981;"></div> Iuran Jimpitan
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: var(--text-muted);">
                <div style="width: 12px; height: 12px; border-radius: 3px; background: #0ea5e9;"></div> Kas Masuk
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: var(--text-muted);">
                <div style="width: 12px; height: 12px; border-radius: 3px; background: #f43f5e;"></div> Kas Keluar
            </div>
        </div>
    </div>
    <div style="position: relative; height: 320px;">
        <canvas id="kasChart"></canvas>
    </div>
</div>

{{-- ===== RECENT LOGS (3 columns) ===== --}}
<div class="grid-mobile-stack" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">

    {{-- Recent Jimpitan --}}
    <div class="card" style="padding: 0;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1rem; font-weight: 700;">Log Jimpitan Terakhir</h3>
            <a href="{{ route('jimpitans.index') }}" class="btn btn-ghost" style="padding: 0.4rem 0.8rem; border-radius: 0.75rem; font-size: 0.75rem;">Lihat →</a>
        </div>
        <div style="padding: 0.75rem 1.5rem 1.5rem;">
            <div class="table-container">
                <table>
                    <tbody>
                        @forelse($recentJimpitans as $jimpitan)
                        <tr>
                            <td style="padding: 1rem 0;">
                                <div style="display: flex; gap: 0.75rem; align-items: center;">
                                    <div style="width: 38px; height: 38px; background: rgba(16,185,129,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; border: 1px solid rgba(16,185,129,0.2); flex-shrink: 0;">🏠</div>
                                    <div>
                                        <div style="font-weight: 700; font-size: 0.9rem;">Rumah {{ $jimpitan->rumah->no_rumah }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($jimpitan->tanggal)->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right; vertical-align: middle;">
                                <div style="color: var(--success); font-weight: 800; font-size: 0.95rem;">+{{ number_format($jimpitan->jumlah, 0, ',', '.') }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" style="text-align: center; color: var(--text-muted); padding: 2rem; font-size: 0.85rem;">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Kas Masuk --}}
    <div class="card" style="padding: 0;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1rem; font-weight: 700;">Log Kas Masuk Terakhir</h3>
            <a href="{{ route('kas-masuks.index') }}" class="btn btn-ghost" style="padding: 0.4rem 0.8rem; border-radius: 0.75rem; font-size: 0.75rem;">Lihat →</a>
        </div>
        <div style="padding: 0.75rem 1.5rem 1.5rem;">
            <div class="table-container">
                <table>
                    <tbody>
                        @forelse($recentKasMasuks as $km)
                        <tr>
                            <td style="padding: 1rem 0;">
                                <div style="display: flex; gap: 0.75rem; align-items: center;">
                                    <div style="width: 38px; height: 38px; background: rgba(14,165,233,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; border: 1px solid rgba(14,165,233,0.2); flex-shrink: 0;">💵</div>
                                    <div>
                                        <div style="font-weight: 700; font-size: 0.9rem; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $km->sumber }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($km->tanggal)->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right; vertical-align: middle;">
                                <div style="color: #0ea5e9; font-weight: 800; font-size: 0.95rem;">+{{ number_format($km->jumlah, 0, ',', '.') }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" style="text-align: center; color: var(--text-muted); padding: 2rem; font-size: 0.85rem;">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Pengeluaran --}}
    <div class="card" style="padding: 0;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1rem; font-weight: 700;">Log Kas Keluar Terakhir</h3>
            <a href="{{ route('pengeluarans.index') }}" class="btn btn-ghost" style="padding: 0.4rem 0.8rem; border-radius: 0.75rem; font-size: 0.75rem;">Lihat →</a>
        </div>
        <div style="padding: 0.75rem 1.5rem 1.5rem;">
            <div class="table-container">
                <table>
                    <tbody>
                        @forelse($recentPengeluarans as $pengeluaran)
                        <tr>
                            <td style="padding: 1rem 0;">
                                <div style="display: flex; gap: 0.75rem; align-items: center;">
                                    <div style="width: 38px; height: 38px; background: rgba(244,63,94,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; border: 1px solid rgba(244,63,94,0.2); flex-shrink: 0;">💸</div>
                                    <div>
                                        <div style="font-weight: 700; font-size: 0.9rem; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $pengeluaran->keterangan }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right; vertical-align: middle;">
                                <div style="color: var(--danger); font-weight: 800; font-size: 0.95rem;">−{{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" style="text-align: center; color: var(--text-muted); padding: 2rem; font-size: 0.85rem;">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ===== CHART.JS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('kasChart').getContext('2d');

    const labels  = @json($chartLabels);
    const jimpitanData    = @json($chartJimpitan);
    const kasMasukData    = @json($chartKasMasuk);
    const pengeluaranData = @json($chartPengeluaran);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Iuran Jimpitan',
                    data: jimpitanData,
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                },
                {
                    label: 'Kas Masuk',
                    data: kasMasukData,
                    backgroundColor: 'rgba(14, 165, 233, 0.7)',
                    borderColor: 'rgba(14, 165, 233, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                },
                {
                    label: 'Kas Keluar',
                    data: pengeluaranData,
                    backgroundColor: 'rgba(244, 63, 94, 0.7)',
                    borderColor: 'rgba(244, 63, 94, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    borderColor: 'rgba(255,255,255,0.08)',
                    borderWidth: 1,
                    padding: 14,
                    titleFont: { size: 13, weight: '700', family: 'Outfit' },
                    bodyFont: { size: 12, family: 'Outfit' },
                    callbacks: {
                        label: ctx => ` ${ctx.dataset.label}: Rp ${ctx.parsed.y.toLocaleString('id-ID')}`
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: { color: '#94a3b8', font: { size: 11, family: 'Outfit' } },
                },
                y: {
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 11, family: 'Outfit' },
                        callback: val => 'Rp ' + (val >= 1000000 ? (val/1000000).toFixed(0)+'jt' : (val >= 1000 ? (val/1000).toFixed(0)+'rb' : val))
                    },
                    beginAtZero: true,
                }
            }
        }
    });
</script>
@endsection
