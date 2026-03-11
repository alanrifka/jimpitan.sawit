@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('kas-masuks.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Daftar</a>
    <h1 style="margin-top: 0.5rem; font-size: 2.5rem; font-weight: 800; letter-spacing: -1px;">Edit Kas Masuk</h1>
    <p style="color: var(--text-muted);">Perbarui data pemasukan kas RT.</p>
</div>

<div class="grid-mobile-stack" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem; align-items: start;">

    <div class="card" style="border-top: 4px solid var(--warning);">
        <form action="{{ route('kas-masuks.update', $kasMasuk) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h4 style="margin-bottom: 1.5rem; color: var(--warning); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Edit Detail Pemasukan</h4>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="sumber">Sumber Pemasukan <span style="color: var(--danger);">*</span></label>
                <input type="text" name="sumber" id="sumber" required value="{{ old('sumber', $kasMasuk->sumber) }}" placeholder="Contoh: Pak Budi Santoso" style="width: 100%;">
                @error('sumber') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="grid-mobile-stack" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="kategori">Kategori <span style="color: var(--danger);">*</span></label>
                    <select name="kategori" id="kategori" required style="width: 100%;">
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat }}" {{ old('kategori', $kasMasuk->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal <span style="color: var(--danger);">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" required value="{{ old('tanggal', $kasMasuk->tanggal->format('Y-m-d')) }}" style="width: 100%;">
                    @error('tanggal') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="jumlah">Jumlah Dana Masuk (Rp) <span style="color: var(--danger);">*</span></label>
                <input type="number" name="jumlah" id="jumlah" required value="{{ old('jumlah', $kasMasuk->jumlah) }}" min="1" style="width: 100%;">
                @error('jumlah') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="keterangan">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" rows="3" style="width: 100%;">{{ old('keterangan', $kasMasuk->keterangan) }}</textarea>
                @error('keterangan') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label>Foto Bukti / Kwitansi (Opsional)</label>
                @if($kasMasuk->bukti_foto)
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Foto Saat Ini:</div>
                        <img src="{{ asset('storage/' . $kasMasuk->bukti_foto) }}" style="max-width: 100%; max-height: 160px; border-radius: 0.75rem; border: 1px solid var(--border);">
                    </div>
                @endif
                <div id="bukti-preview-area" style="width: 100%; background: rgba(255,255,255,0.02); border: 2px dashed var(--border); border-radius: 1rem; padding: 1.25rem; text-align: center; cursor: pointer;" onclick="document.getElementById('bukti_foto').click()">
                    <div id="bukti-placeholder">
                        <div style="font-size: 1.2rem; margin-bottom: 0.25rem;">📎</div>
                        <div style="color: var(--text-muted); font-size: 0.8rem;">{{ $kasMasuk->bukti_foto ? 'Klik untuk ganti foto' : 'Klik untuk unggah foto baru' }}</div>
                        <div style="color: var(--text-muted); font-size: 0.75rem;">Max 5MB (JPG, PNG)</div>
                    </div>
                    <img id="bukti-preview-img" style="display: none; max-width: 100%; max-height: 180px; border-radius: 0.75rem; margin: 0 auto;">
                </div>
                <input type="file" name="bukti_foto" id="bukti_foto" hidden accept="image/*" onchange="previewBukti(this)">
                @error('bukti_foto') <div style="color: var(--danger); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
            </div>

            <div class="flex-mobile-stack" style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 2; justify-content: center; padding: 1rem;">💾 Simpan Perubahan</button>
                <a href="{{ route('kas-masuks.index') }}" class="btn btn-ghost" style="flex: 1; justify-content: center;">Batal</a>
            </div>
        </form>
    </div>

    {{-- Current Data Info --}}
    <div class="card" style="background: rgba(245,158,11,0.05); border-color: rgba(245,158,11,0.2);">
        <h4 style="margin-bottom: 1.25rem; color: var(--warning);">📋 Data Tersimpan</h4>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Sumber</div>
                <div style="font-weight: 700; margin-top: 0.25rem;">{{ $kasMasuk->sumber }}</div>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Kategori</div>
                <div style="font-weight: 700; margin-top: 0.25rem;">{{ $kasMasuk->kategori }}</div>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Jumlah</div>
                <div style="font-weight: 800; font-size: 1.25rem; color: var(--success); margin-top: 0.25rem;">Rp {{ number_format($kasMasuk->jumlah, 0, ',', '.') }}</div>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Dicatat</div>
                <div style="margin-top: 0.25rem;">{{ $kasMasuk->tanggal->format('d F Y') }}</div>
            </div>
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
