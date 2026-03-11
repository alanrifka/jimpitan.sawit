@extends('layouts.app')

@section('content')
<div class="flex-mobile-stack" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 2.5rem; font-weight: 800; letter-spacing: -1px;">Daftar Petugas</h1>
        <p style="color: var(--text-muted);">Manajemen akun pengelola sistem Warga Sawit.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">+ Tambah Petugas</a>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Petugas</th>
                    <th>Email</th>
                    <th>Dibuat Pada</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" style="width: 35px; height: 35px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border);">
                            @else
                                <div style="width: 35px; height: 35px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <div style="font-weight: 700;">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td style="color: var(--text-muted); font-size: 0.85rem;">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-ghost" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Edit</a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost" style="padding: 0.5rem 1rem; font-size: 0.8rem; color: var(--danger); border-color: rgba(244, 63, 94, 0.2);">Hapus</button>
                            </form>
                            @else
                            <span style="font-size: 0.7rem; color: var(--text-muted); padding: 0.5rem; border: 1px solid var(--border); border-radius: 0.5rem; background: rgba(255,255,255,0.02);">Akun Anda</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem;">
        {{ $users->links() }}
    </div>
</div>
@endsection
