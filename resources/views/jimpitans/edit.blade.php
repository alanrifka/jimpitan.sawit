@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('jimpitans.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Daftar</a>
    <h1 style="margin-top: 0.5rem; font-size: 2.5rem; font-weight: 800; letter-spacing: -1px;">Perbarui Iuran Jimpitan</h1>
    <p style="color: var(--text-muted);">Ubah data setoran dana masuk iuran harian.</p>
</div>

<div class="card" style="max-width: 600px; border-top: 4px solid var(--warning);">
    <form action="{{ route('jimpitans.update', $jimpitan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="rumah_id">Pilih Rumah</label>
            <select name="rumah_id" id="rumah_id" required>
                @foreach($rumahs as $rumah)
                    <option value="{{ $rumah->id }}" {{ old('rumah_id', $jimpitan->rumah_id) == $rumah->id ? 'selected' : '' }}>
                        {{ $rumah->no_rumah }} ({{ $rumah->kepalaKeluarga->nama ?? 'Tanpa Nama' }})
                    </option>
                @endforeach
            </select>
            @error('rumah_id') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="tanggal">Tanggal Terkumpul</label>
                <input type="date" name="tanggal" id="tanggal" required value="{{ old('tanggal', $jimpitan->tanggal) }}">
                @error('tanggal') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah Setoran (Rp)</label>
                <input type="number" name="jumlah" id="jumlah" required value="{{ old('jumlah', $jimpitan->jumlah) }}" min="0">
                @error('jumlah') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3">{{ old('keterangan', $jimpitan->keterangan) }}</textarea>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Update Iuran Jimpitan</button>
        </div>
    </form>
</div>
@endsection
