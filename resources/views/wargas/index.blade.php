@extends('layouts.app')

@section('content')
<div class="flex-mobile-stack" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap;">
    <h1>Daftar Kepala Keluarga</h1>
    <div class="flex-mobile-stack" style="display: flex; gap: 0.5rem; flex-grow: 1; justify-content: flex-end;">
        <form action="{{ route('wargas.index') }}" method="GET" class="flex-mobile-stack" style="display: flex; gap: 0.5rem; flex-grow: 1; max-width: 600px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau NIK..." style="flex: 2;">
            <select name="status" style="flex: 1;">
                <option value="">Semua Status</option>
                <option value="Tetap" {{ request('status') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Kontrak" {{ request('status') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
            </select>
            <button type="submit" class="btn btn-primary" style="padding: 0 1.5rem;">Cari</button>
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('wargas.index') }}" class="btn btn-ghost" style="padding: 0 1rem; display: flex; align-items: center;">Reset</a>
            @endif
        </form>
        <a href="{{ route('wargas.create') }}" class="btn btn-primary">+ Tambah Keluarga</a>
    </div>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Kepala Keluarga</th>
                    <th>NIK</th>
                    <th>No. HP</th>
                    <th>Status</th>
                    <th>Anggota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wargas as $warga)
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $warga->nama }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted)">
                            {{ $warga->jenis_kelamin }} • <span style="color: var(--secondary);">Kepala Keluarga</span>
                        </div>
                    </td>
                    <td>{{ $warga->nik ?? '-' }}</td>
                    <td>{{ $warga->no_hp ?? '-' }}</td>
                    <td>
                        <span style="padding: 0.25rem 0.5rem; border-radius: 0.5rem; font-size: 0.75rem; background: {{ $warga->status_warga == 'Tetap' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(245, 158, 11, 0.1)' }}; color: {{ $warga->status_warga == 'Tetap' ? 'var(--success)' : 'var(--warning)' }}">
                            {{ $warga->status_warga }}
                        </span>
                    </td>
                    <td>
                        <span class="btn btn-ghost" style="padding: 0.2rem 0.6rem; font-size: 0.75rem; pointer-events: none;">
                            {{ $warga->anggotaKeluarga->count() }} Orang
                        </span>
                    </td>
                    <td>
                        <div class="grid-mobile-stack" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <a href="{{ route('wargas.show', $warga) }}" class="btn btn-primary" style="padding: 0.5rem; font-size: 0.8rem; background: var(--primary-glow); border: 1px solid var(--primary);">Detail</a>
                            <a href="{{ route('wargas.edit', $warga) }}" class="btn btn-ghost" style="padding: 0.5rem;">Edit</a>
                            <form action="{{ route('wargas.destroy', $warga) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus seluruh data keluarga ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost" style="padding: 0.5rem; color: var(--danger);">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 3rem;">Belum ada data keluarga.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem;">
        {{ $wargas->links() }}
    </div>
</div>
@endsection
