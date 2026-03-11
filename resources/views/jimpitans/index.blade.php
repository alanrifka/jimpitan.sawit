@extends('layouts.app')

@section('content')
<div class="flex-mobile-stack" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap;">
    <div>
        <h1 style="font-size: 2.5rem; font-weight: 800; letter-spacing: -1px;">Daftar Iuran Jimpitan</h1>
        <p style="color: var(--text-muted);">Riwayat seluruh setoran iuran harian/jimpitan warga Sawit.</p>
    </div>
    <div class="flex-mobile-stack" style="display: flex; gap: 0.5rem; flex-grow: 1; justify-content: flex-end; align-items: flex-end;">
        <form action="{{ route('jimpitans.index') }}" method="GET" class="flex-mobile-stack" style="display: flex; gap: 0.5rem; flex-grow: 1; max-width: 800px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Rumah/Nama..." style="flex: 2;">
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
                <a href="{{ route('jimpitans.index') }}" class="btn btn-ghost" style="display: flex; align-items: center;">Reset</a>
            @endif
        </form>
        <a href="{{ route('jimpitans.create') }}" class="btn btn-primary" style="background: var(--success); white-space: nowrap;">+ Input Baru</a>
    </div>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Informasi Setoran</th>
                    <th>Tanggal</th>
                    <th>Jumlah (Rp)</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jimpitans as $jimpitan)
                <tr>
                    <td>
                        <div style="font-weight: 700;">Rumah {{ $jimpitan->rumah->no_rumah }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">
                            KK: {{ $jimpitan->rumah->kepalaKeluarga->nama ?? 'Tanpa Nama' }}
                        </div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($jimpitan->tanggal)->format('d/m/Y') }}</td>
                    <td>
                        <div style="color: var(--success); font-weight: 800;">+Rp {{ number_format($jimpitan->jumlah, 0, ',', '.') }}</div>
                    </td>
                    <td>{{ $jimpitan->keterangan ?? '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('jimpitans.edit', $jimpitan) }}" class="btn btn-ghost" style="padding: 0.5rem; color: var(--warning); border: 1px solid rgba(245, 158, 11, 0.2);">Edit</a>
                            <form action="{{ route('jimpitans.destroy', $jimpitan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus catatan iuran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost" style="padding: 0.5rem; color: var(--danger); border: 1px solid rgba(244, 63, 94, 0.2);">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 4rem;">Belum ada riwayat iuran jimpitan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem;">
        {{ $jimpitans->links() }}
    </div>
</div>
@endsection
