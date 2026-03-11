@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('pengeluarans.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Daftar</a>
    <h1 style="margin-top: 0.5rem;">Edit Catatan Pengeluaran</h1>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('pengeluarans.update', $pengeluaran) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="tanggal">Tanggal Pengeluaran</label>
            <input type="date" name="tanggal" id="tanggal" required value="{{ old('tanggal', $pengeluaran->tanggal) }}">
            @error('tanggal') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah Dana Keluar (Rp)</label>
            <input type="number" name="jumlah" id="jumlah" required value="{{ old('jumlah', $pengeluaran->jumlah) }}" min="0">
            @error('jumlah') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan / Keperluan</label>
            <textarea name="keterangan" id="keterangan" rows="3" required>{{ old('keterangan', $pengeluaran->keterangan) }}</textarea>
            @error('keterangan') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        @if($pengeluaran->bukti_foto)
            <div style="margin-bottom: 1rem;">
                <label>Bukti Saat Ini:</label>
                <img src="{{ asset('storage/' . $pengeluaran->bukti_foto) }}" style="max-width: 200px; border-radius: 0.5rem; display: block; margin-top: 0.5rem;">
            </div>
        @endif

        <div class="form-group">
            <label for="bukti_foto">Ganti Foto Bukti (Opsional)</label>
            <input type="file" name="bukti_foto" id="bukti_foto" accept="image/*" style="padding: 0.5rem; background: rgba(255,255,255,0.02);">
            @error('bukti_foto') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Update Pengeluaran</button>
        </div>
    </form>
</div>
@endsection
