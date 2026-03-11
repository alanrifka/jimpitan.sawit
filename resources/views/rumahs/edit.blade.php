@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('rumahs.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Daftar</a>
    <h1 style="margin-top: 0.5rem; font-size: 2.5rem; font-weight: 800; letter-spacing: -1px;">Perbarui Data Rumah</h1>
    <p style="color: var(--text-muted);">Ubah informasi alamat atau ganti Kepala Keluarga rumah.</p>
</div>

<div class="card" style="max-width: 800px; border-top: 4px solid var(--secondary);">
    <form action="{{ route('rumahs.update', $rumah) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
            <!-- Identitas Fisik -->
            <div>
                <h4 style="margin-bottom: 1.25rem; font-size: 0.9rem; color: var(--primary); text-transform: uppercase; letter-spacing: 1px;">Identitas Fisik</h4>
                
                <div class="form-group">
                    <label for="no_rumah">Nomor Rumah <span style="color: var(--danger);">*</span></label>
                    <input type="text" name="no_rumah" id="no_rumah" required value="{{ old('no_rumah', $rumah->no_rumah) }}">
                    @error('no_rumah') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="blok">Blok / Gang</label>
                    <input type="text" name="blok" id="blok" value="{{ old('blok', $rumah->blok) }}">
                    @error('blok') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Kepemilikan -->
            <div>
                <h4 style="margin-bottom: 1.25rem; font-size: 0.9rem; color: var(--secondary); text-transform: uppercase; letter-spacing: 1px;">Kepemilikan</h4>

                <div class="form-group">
                    <label for="kepala_keluarga_id">Kepala Keluarga</label>
                    <select name="kepala_keluarga_id" id="kepala_keluarga_id">
                        <option value="">-- Tanpa Kepala Keluarga --</option>
                        @foreach($wargas as $warga)
                            <option value="{{ $warga->id }}" {{ old('kepala_keluarga_id', $rumah->kepala_keluarga_id) == $warga->id ? 'selected' : '' }}>
                                {{ $warga->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Detail Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" rows="3">{{ old('alamat', $rumah->alamat) }}</textarea>
        </div>

        <div style="margin-top: 3rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 2; justify-content: center; padding: 1.2rem;">Simpan Perubahan</button>
            <a href="{{ route('rumahs.index') }}" class="btn btn-ghost" style="flex: 1; justify-content: center;">Batal</a>
        </div>
    </form>
</div>
@endsection
