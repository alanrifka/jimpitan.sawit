@extends('layouts.app')

@section('content')
<div class="flex-mobile-stack" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap;">
    <div>
        <h1 style="font-size: 2.5rem; font-weight: 800; letter-spacing: -1px;">Kas Masuk</h1>
        <p style="color: var(--text-muted);">Riwayat seluruh pemasukan kas RT selain iuran jimpitan.</p>
    </div>
    <div class="flex-mobile-stack" style="display: flex; gap: 0.5rem; flex-grow: 1; justify-content: flex-end; align-items: flex-end;">
        <form action="{{ route('kas-masuks.index') }}" method="GET" class="flex-mobile-stack" style="display: flex; gap: 0.5rem; flex-grow: 1; max-width: 900px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari sumber atau keterangan..." style="flex: 2;">
            <select name="kategori" style="flex: 1;">
                <option value="">Semua Kategori</option>
                @foreach(['Rutin', 'Donasi', 'Sumbangan', 'Subsidi Pemerintah', 'Iuran Wajib', 'Lain-lain'] as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
            <select name="month" style="flex: 1;">
                <option value="">Bulan</option>
                @for($m=1; $m<=12; $m++)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->locale('id')->monthName }}</option>
                @endfor
            </select>
            <select name="year" style="flex: 1;">
                <option value="">Tahun</option>
                @for($y=date('Y'); $y>=date('Y')-5; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="btn btn-primary">Cari</button>
            @if(request()->anyFilled(['search', 'kategori', 'month', 'year']))
                <a href="{{ route('kas-masuks.index') }}" class="btn btn-ghost" style="display: flex; align-items: center;">Reset</a>
            @endif
        </form>
        <a href="{{ route('kas-masuks.create') }}" class="btn btn-primary" style="background: var(--success); white-space: nowrap;">+ Tambah Kas Masuk</a>
    </div>
</div>

{{-- Summary Card --}}
<div class="card" style="margin-bottom: 2rem; border-left: 4px solid var(--success); padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <div>
        <div style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; font-weight: 600; letter-spacing: 1px;">Total Kas Masuk (Filter Aktif)</div>
        <div style="font-size: 2rem; font-weight: 800; margin-top: 0.25rem; color: var(--success);">Rp {{ number_format($totalKasMasuk, 0, ',', '.') }}</div>
    </div>
    <div style="font-size: 2rem;">💰</div>
</div>

{{-- Table --}}
<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Sumber Pemasukan</th>
                    <th>Kategori</th>
                    <th>Jumlah (Rp)</th>
                    <th>Keterangan</th>
                    <th>Bukti</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kasMasuks as $item)
                <tr>
                    <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td style="font-weight: 700;">{{ $item->sumber }}</td>
                    <td>
                        @php
                            $colors = [
                                'Rutin'               => ['bg' => 'rgba(99,102,241,0.1)',  'color' => '#818cf8'],
                                'Donasi'              => ['bg' => 'rgba(16,185,129,0.1)',  'color' => '#10b981'],
                                'Sumbangan'           => ['bg' => 'rgba(236,72,153,0.1)',  'color' => '#ec4899'],
                                'Subsidi Pemerintah'  => ['bg' => 'rgba(245,158,11,0.1)',  'color' => '#f59e0b'],
                                'Iuran Wajib'         => ['bg' => 'rgba(14,165,233,0.1)',  'color' => '#0ea5e9'],
                                'Lain-lain'           => ['bg' => 'rgba(148,163,184,0.1)', 'color' => '#94a3b8'],
                            ];
                            $c = $colors[$item->kategori] ?? $colors['Lain-lain'];
                        @endphp
                        <span style="padding: 0.3rem 0.7rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 600; background: {{ $c['bg'] }}; color: {{ $c['color'] }};">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td>
                        <div style="color: var(--success); font-weight: 800; font-size: 1rem;">+Rp {{ number_format($item->jumlah, 0, ',', '.') }}</div>
                    </td>
                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--text-muted); font-size: 0.9rem;">
                        {{ $item->keterangan ?? '-' }}
                    </td>
                    <td>
                        @if($item->bukti_foto)
                            <a href="{{ asset('storage/' . $item->bukti_foto) }}" target="_blank" style="color: var(--primary); text-decoration: none; font-size: 0.85rem;">Lihat 📎</a>
                        @else
                            <span style="color: var(--text-muted); font-size: 0.85rem;">-</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                            <a href="{{ route('kas-masuks.edit', $item) }}" class="btn btn-ghost" style="padding: 0.4rem 0.9rem; font-size: 0.8rem; color: var(--warning); border-color: rgba(245,158,11,0.2);">Edit</a>
                            <form action="{{ route('kas-masuks.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data kas masuk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-ghost" style="padding: 0.4rem 0.9rem; font-size: 0.8rem; color: var(--danger); border-color: rgba(244,63,94,0.2);">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 4rem;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">📭</div>
                        <div>Belum ada data kas masuk.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem;">
        {{ $kasMasuks->links() }}
    </div>
</div>
@endsection
