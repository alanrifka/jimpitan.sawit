@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('wargas.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Daftar</a>
    <h1 style="margin-top: 0.5rem;">Edit Data Warga</h1>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('wargas.update', $warga) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" required value="{{ old('nama', $warga->nama) }}">
            @error('nama') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="kepala_keluarga_id">Kepala Keluarga (Jika Anggota)</label>
                <select name="kepala_keluarga_id" id="kepala_keluarga_id">
                    <option value="">-- Kepala Keluarga Sendiri --</option>
                    @foreach($kepalaKeluargas as $kk)
                        <option value="{{ $kk->id }}" {{ old('kepala_keluarga_id', $warga->kepala_keluarga_id) == $kk->id ? 'selected' : '' }}>{{ $kk->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="hubungan_keluarga">Hubungan Keluarga</label>
                <select name="hubungan_keluarga" id="hubungan_keluarga">
                    <option value="">-- N/A --</option>
                    <option value="Istri" {{ old('hubungan_keluarga', $warga->hubungan_keluarga) == 'Istri' ? 'selected' : '' }}>Istri</option>
                    <option value="Anak" {{ old('hubungan_keluarga', $warga->hubungan_keluarga) == 'Anak' ? 'selected' : '' }}>Anak</option>
                    <option value="Orang Tua" {{ old('hubungan_keluarga', $warga->hubungan_keluarga) == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="Lainnya" {{ old('hubungan_keluarga', $warga->hubungan_keluarga) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" name="nik" id="nik" value="{{ old('nik', $warga->nik) }}">
            @error('nik') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="no_hp">No. HP / WhatsApp</label>
            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $warga->no_hp) }}">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status_warga">Status Warga</label>
                <select name="status_warga" id="status_warga" required>
                    <option value="Tetap" {{ old('status_warga', $warga->status_warga) == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="Kontrak" {{ old('status_warga', $warga->status_warga) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                    <option value="Kosong" {{ old('status_warga', $warga->status_warga) == 'Kosong' ? 'selected' : '' }}>Kosong</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $warga->is_active) ? 'checked' : '' }} style="width: auto;">
            <label for="is_active" style="margin-bottom: 0;">Warga Aktif (Masih tinggal di sini)</label>
        </div>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
