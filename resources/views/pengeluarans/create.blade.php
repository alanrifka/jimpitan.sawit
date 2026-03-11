@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('pengeluarans.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Daftar</a>
    <h1 style="margin-top: 0.5rem;">Tambah Catatan Pengeluaran</h1>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('pengeluarans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="tanggal">Tanggal Pengeluaran</label>
            <input type="date" name="tanggal" id="tanggal" required value="{{ date('Y-m-d') }}">
            @error('tanggal') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah Dana Keluar (Rp)</label>
            <input type="number" name="jumlah" id="jumlah" required value="{{ old('jumlah') }}" min="0" placeholder="Contoh: 50000">
            @error('jumlah') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan / Keperluan</label>
            <textarea name="keterangan" id="keterangan" rows="3" required placeholder="Contoh: Beli sapu lidi & plastik sampah">{{ old('keterangan') }}</textarea>
            @error('keterangan') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="bukti_foto">Foto Bukti / Nota (Opsional)</label>
            <input type="file" name="bukti_foto" id="bukti_foto" accept="image/*" style="padding: 0.5rem; background: rgba(255,255,255,0.02);">
            <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.25rem;">Format dokumen: JPG, PNG (Max 2MB)</p>
            @error('bukti_foto') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Simpan Pengeluaran</button>
        </div>
    </form>
</div>
@endsection
