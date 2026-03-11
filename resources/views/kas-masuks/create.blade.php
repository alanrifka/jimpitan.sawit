@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('kas-masuks.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Daftar</a>
    <h1 style="margin-top: 0.5rem; font-size: 2.5rem; font-weight: 800; letter-spacing: -1px;">Tambah Kas Masuk</h1>
    <p style="color: var(--text-muted);">Catat pemasukan kas RT dari berbagai sumber.</p>
</div>

<div class="grid-mobile-stack" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem; align-items: start;">

    <div class="card" style="border-top: 4px solid var(--success);">
        <form action="{{ route('kas-masuks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h4 style="margin-bottom: 1.5rem; color: var(--success); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Detail Pemasukan</h4>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="sumber">Sumber Pemasukan <span style="color: var(--danger);">*</span></label>
                <input type="text" name="sumber" id="sumber" required value="{{ old('sumber') }}" placeholder="Contoh: Pak Budi Santoso, Donasi Baznas, dll." style="width: 100%;">
                @error('sumber') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="grid-mobile-stack" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="kategori">Kategori <span style="color: var(--danger);">*</span></label>
                    <select name="kategori" id="kategori" required style="width: 100%;">
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal <span style="color: var(--danger);">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}" style="width: 100%;">
                    @error('tanggal') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="jumlah">Jumlah Dana Masuk (Rp) <span style="color: var(--danger);">*</span></label>
                <input type="number" name="jumlah" id="jumlah" required value="{{ old('jumlah') }}" min="1" placeholder="Contoh: 500000" style="width: 100%;">
                @error('jumlah') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="keterangan">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" rows="3" placeholder="Contoh: Donasi pembangunan pos ronda dari warga Blok A" style="width: 100%;">{{ old('keterangan') }}</textarea>
                @error('keterangan') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="bukti_foto">Foto Bukti / Kwitansi (Opsional)</label>
                <div id="bukti-preview-area" style="width: 100%; background: rgba(255,255,255,0.02); border: 2px dashed var(--border); border-radius: 1rem; padding: 1.5rem; text-align: center; cursor: pointer;" onclick="document.getElementById('bukti_foto').click()">
                    <div id="bukti-placeholder">
                        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">📎</div>
                        <div style="color: var(--text-muted); font-size: 0.85rem;">Klik untuk unggah foto bukti</div>
                        <div style="color: var(--text-muted); font-size: 0.75rem; margin-top: 0.25rem;">Max 5MB (JPG, PNG)</div>
                    </div>
                    <img id="bukti-preview-img" style="display: none; max-width: 100%; max-height: 200px; border-radius: 0.75rem; margin: 0 auto;">
                </div>
                <input type="file" name="bukti_foto" id="bukti_foto" hidden accept="image/*" onchange="previewBukti(this)">
                @error('bukti_foto') <div style="color: var(--danger); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
            </div>

            <div class="flex-mobile-stack" style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 2; justify-content: center; padding: 1rem; background: var(--success);">💾 Simpan Kas Masuk</button>
                <a href="{{ route('kas-masuks.index') }}" class="btn btn-ghost" style="flex: 1; justify-content: center;">Batal</a>
            </div>
        </form>
    </div>

    {{-- Info Card --}}
    <div class="card" style="background: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.2);">
        <h4 style="margin-bottom: 1.25rem; color: var(--success);">📌 Kategori Kas Masuk</h4>
        <ul style="color: var(--text-muted); font-size: 0.85rem; padding-left: 1rem; line-height: 2.2;">
            <li><strong style="color: #818cf8;">Rutin</strong> — Pemasukan berkala bulanan</li>
            <li><strong style="color: #10b981;">Donasi</strong> — Sumbangan tidak mengikat</li>
            <li><strong style="color: #ec4899;">Sumbangan</strong> — Dana dari warga/tamu</li>
            <li><strong style="color: #f59e0b;">Subsidi Pemerintah</strong> — Dana dari kelurahan/desa</li>
            <li><strong style="color: #0ea5e9;">Iuran Wajib</strong> — Iuran RT wajib selain jimpitan</li>
            <li><strong style="color: #94a3b8;">Lain-lain</strong> — Sumber pemasukan lainnya</li>
        </ul>

        <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(255,255,255,0.03); border-radius: 0.75rem; border: 1px solid var(--border);">
            <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.25rem;">💡 Catatan</div>
            <div style="font-size: 0.85rem; line-height: 1.6;">Iuran harian (jimpitan) dicatat di menu <strong>Iuran Jimpitan</strong>. Menu ini untuk pemasukan kas lainnya.</div>
        </div>
    </div>

</div>

<script>
    function previewBukti(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('bukti-preview-img').src = e.target.result;
                document.getElementById('bukti-preview-img').style.display = 'block';
                document.getElementById('bukti-placeholder').style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
