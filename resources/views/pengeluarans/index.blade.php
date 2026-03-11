@extends('layouts.app')

@section('content')
<div class="flex-mobile-stack" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap;">
    <h1>Daftar Pengeluaran</h1>
    <div class="flex-mobile-stack" style="display: flex; gap: 0.5rem; flex-grow: 1; justify-content: flex-end;">
        <form action="{{ route('pengeluarans.index') }}" method="GET" class="flex-mobile-stack" style="display: flex; gap: 0.5rem; flex-grow: 1; max-width: 800px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari keterangan..." style="flex: 2;">
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
            @if(request()->anyFilled(['search', 'month', 'year']))
                <a href="{{ route('pengeluarans.index') }}" class="btn btn-ghost" style="display: flex; align-items: center;">Reset</a>
            @endif
        </form>
        <a href="{{ route('pengeluarans.create') }}" class="btn btn-primary" style="white-space: nowrap;">+ Tambah Pengeluaran</a>
    </div>
</div>

<div class="card" style="margin-bottom: 2rem; border-left: 4px solid var(--danger);">
    <div style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Total Pengeluaran</div>
    <div style="font-size: 1.8rem; font-weight: 700; margin-top: 0.5rem; color: var(--danger);">Rp {{ number_format($pengeluarans->sum('jumlah'), 0, ',', '.') }}</div>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengeluarans as $pengeluaran)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d M Y') }}</td>
                    <td style="font-weight: 500;">{{ $pengeluaran->keterangan }}</td>
                    <td style="color: var(--danger); font-weight: 600;">- Rp {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</td>
                    <td>
                        @if($pengeluaran->bukti_foto)
                            <a href="{{ asset('storage/' . $pengeluaran->bukti_foto) }}" target="_blank" style="color: var(--primary); text-decoration: none; font-size: 0.85rem;">Lihat Bukti</a>
                        @else
                            <span style="color: var(--text-muted); font-size: 0.85rem;">Tidak ada</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('pengeluarans.edit', $pengeluaran) }}" class="btn btn-ghost" style="padding: 0.5rem;">Edit</a>
                            <form action="{{ route('pengeluarans.destroy', $pengeluaran) }}" method="POST" onsubmit="return confirm('Hapus catatan pengeluaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost" style="padding: 0.5rem; color: var(--danger);">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 3rem;">Belum ada catatan pengeluaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem;">
        {{ $pengeluarans->links() }}
    </div>
</div>
@endsection
