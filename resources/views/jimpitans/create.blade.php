@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('jimpitans.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Daftar</a>
    <h1 style="margin-top: 0.5rem; font-size: 2.5rem; font-weight: 800; letter-spacing: -1px;">Setor Iuran Jimpitan</h1>
    <p style="color: var(--text-muted);">Pencatatan dana masuk dari iuran harian/jimpitan warga.</p>
</div>

<div class="grid-mobile-stack" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem; align-items: start;">
    
    <div class="card" style="border-top: 4px solid var(--success);">
        <form action="{{ route('jimpitans.store') }}" method="POST">
            @csrf

            <h4 style="margin-bottom: 1.5rem; color: var(--success); font-size: 0.9rem; text-transform: uppercase;">Detail Setoran</h4>
            
            <div class="form-group">
                <label for="rumah_id">Pilih Rumah <span style="color: var(--danger);">*</span></label>
                <select name="rumah_id" id="rumah_id" required class="select-premium">
                    <option value="">-- Cari Nomor Rumah / Kepala Keluarga --</option>
                    @foreach($rumahs as $rumah)
                        <option value="{{ $rumah->id }}" {{ old('rumah_id') == $rumah->id ? 'selected' : '' }}>
                            {{ $rumah->no_rumah }} ({{ $rumah->kepalaKeluarga->nama ?? 'Kosong' }})
                        </option>
                    @endforeach
                </select>
                @error('rumah_id') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="grid-mobile-stack" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="tanggal">Tanggal Penagihan</label>
                    <input type="date" name="tanggal" id="tanggal" required value="{{ date('Y-m-d') }}">
                    @error('tanggal') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah Setoran (Rp)</label>
                    <input type="number" name="jumlah" id="jumlah" required value="2000" min="0">
                    @error('jumlah') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" rows="2" placeholder="Contoh: Jimpitan Minggu ke-1 Maret">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex-mobile-stack" style="margin-top: 3rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">Simpan Iuran Jimpitan</button>
            </div>
        </form>
    </div>

    <!-- Info/Helper Card -->
    <div class="card" style="background: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.2);">
        <h4 style="margin-bottom: 1rem; color: var(--success);">💡 Tips Input</h4>
        <ul style="color: var(--text-muted); font-size: 0.85rem; padding-left: 1rem; line-height: 1.8;">
            <li>Pastikan Nama Kepala Keluarga sesuai dengan pemegang iuran di rumah tersebut.</li>
            <li>Default jumlah diset ke <strong>Rp 2.000</strong> (Nilai umum jimpitan harian).</li>
            <li>Tanggal otomatis terisi hari ini, namun dapat diubah jika ingin menginput data iuran tanggal lalu.</li>
        </ul>
    </div>

</div>
@endsection
