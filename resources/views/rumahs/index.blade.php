@extends('layouts.app')

@section('content')
<div class="flex-mobile-stack" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; gap: 1rem; flex-wrap: wrap;">
    <h1>Daftar Rumah</h1>
    <div class="flex-mobile-stack" style="display: flex; gap: 0.5rem; flex-grow: 1; justify-content: flex-end;">
        <form action="{{ route('rumahs.index') }}" method="GET" class="flex-mobile-stack" style="display: flex; gap: 0.5rem; flex-grow: 1; max-width: 600px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Rumah atau Blok..." style="flex: 2;">
            <select name="status" style="flex: 1;">
                <option value="">Semua Status</option>
                <option value="Tetap" {{ request('status') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Kontrak" {{ request('status') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
            </select>
            <button type="submit" class="btn btn-primary" style="padding: 0 1.5rem;">Cari</button>
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('rumahs.index') }}" class="btn btn-ghost" style="padding: 0 1rem; display: flex; align-items: center;">Reset</a>
            @endif
        </form>
        <a href="{{ route('rumahs.create') }}" class="btn btn-primary">+ Tambah Rumah</a>
    </div>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No. Rumah</th>
                    <th>Blok</th>
                    <th>Kepala Keluarga</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rumahs as $rumah)
                <tr>
                    <td><span style="font-weight: 600; color: var(--primary);">{{ $rumah->no_rumah }}</span></td>
                    <td>{{ $rumah->blok ?? '-' }}</td>
                    <td>
                        @if($rumah->kepalaKeluarga)
                            <div style="font-weight: 500;">{{ $rumah->kepalaKeluarga->nama }}</div>
                        @else
                            <span style="color: var(--text-muted); font-style: italic;">Belum diatur</span>
                        @endif
                    </td>
                    <td style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $rumah->alamat ?? '-' }}
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('rumahs.edit', $rumah) }}" class="btn btn-ghost" style="padding: 0.5rem;">Edit</a>
                            <form action="{{ route('rumahs.destroy', $rumah) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data rumah ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost" style="padding: 0.5rem; color: var(--danger);">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 3rem;">Belum ada data rumah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem;">
        {{ $rumahs->links() }}
    </div>
</div>
@endsection
