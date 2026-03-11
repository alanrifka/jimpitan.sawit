@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: end;">
    <div>
        <a href="{{ route('wargas.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Daftar</a>
        <h1 style="margin-top: 0.5rem; font-size: 2.5rem;">Informasi Keluarga</h1>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('jimpitans.print', $warga) }}" target="_blank" class="btn btn-primary" style="background: var(--success); border-color: var(--success);">🖨️ Cetak Kartu Jimpitan</a>
        <a href="{{ route('wargas.edit', $warga) }}" class="btn btn-ghost">Edit Keluarga</a>
        <form action="{{ route('wargas.destroy', $warga) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus seluruh keluarga ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-ghost" style="color: var(--danger);">Hapus Keluarga</button>
        </form>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Head of Family Info -->
    <div class="card" style="height: fit-content;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="width: 80px; height: 80px; background: var(--primary-glow); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem;">👤</div>
            <h2 style="font-weight: 700; color: var(--text);">{{ $warga->nama }}</h2>
            <p style="color: var(--primary); font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Kepala Keluarga</p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
            <div style="padding-bottom: 0.75rem; border-bottom: 1px solid var(--border);">
                <label style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">NIK</label>
                <div style="font-weight: 500;">{{ $warga->nik ?? '-' }}</div>
            </div>
            <div style="padding-bottom: 0.75rem; border-bottom: 1px solid var(--border);">
                <label style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Nomor HP</label>
                <div style="font-weight: 500;">{{ $warga->no_hp ?? '-' }}</div>
            </div>
            <div style="padding-bottom: 0.75rem; border-bottom: 1px solid var(--border);">
                <label style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Status Warga</label>
                <div style="font-weight: 500;">{{ $warga->status_warga }}</div>
            </div>
            <div>
                <label style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Rumah Terkait</label>
                @forelse($warga->rumahs as $rumah)
                    <div style="font-weight: 500; margin-top: 0.25rem; color: var(--primary);">🏠 Blok {{ $rumah->blok }} - No {{ $rumah->no_rumah }}</div>
                @empty
                    <div style="font-size: 0.85rem; color: var(--text-muted); font-style: italic;">Belum terdaftar di rumah mana pun</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Family Members List -->
    <div>
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700;">Anggota Keluarga ({{ $warga->anggotaKeluarga->count() }})</h3>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Hubungan</th>
                            <th>L/P</th>
                            <th>NIK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($warga->anggotaKeluarga as $anggota)
                        <tr>
                            <td style="font-weight: 600;">{{ $anggota->nama }}</td>
                            <td>
                                <span style="padding: 0.25rem 0.6rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 600; background: rgba(236, 72, 153, 0.1); color: var(--secondary);">
                                    {{ $anggota->hubungan_keluarga }}
                                </span>
                            </td>
                            <td>{{ $anggota->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                            <td style="color: var(--text-muted); font-size: 0.9rem;">{{ $anggota->nik ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 3rem; font-style: italic;">Tidak ada anggota keluarga yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Summary/Notice card -->
        <div class="card" style="margin-top: 2rem; background: var(--surface); border: none;">
            <p style="font-size: 0.9rem; color: var(--text-muted);">
                💡 <strong>Info:</strong> Data anggota keluarga di atas terikat secara sistem dengan akun <strong>{{ $warga->nama }}</strong> sebagai Kepala Keluarga. Pengubahan hubungan keluarga dapat dilakukan melalui menu Edit.
            </p>
        </div>
    </div>
</div>
@endsection
