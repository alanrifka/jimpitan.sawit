@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('wargas.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Daftar</a>
    <h1 style="margin-top: 0.5rem;">Input Data Keluarga Baru</h1>
</div>

<form action="{{ route('wargas.store') }}" method="POST">
    @csrf
    
    <div class="grid-mobile-stack" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: start;">
        
        <!-- Section: Data Kepala Keluarga -->
        <div>
            <div class="card" style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1.5rem; color: var(--primary);">1. Data Kepala Keluarga</h3>
                
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" required value="{{ old('nama') }}" placeholder="Budi Santoso">
                </div>

                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" placeholder="32xxxxxxxxxxxxxx">
                </div>

                <div class="form-group">
                    <label for="no_hp">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                </div>

                <div class="grid-mobile-stack" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_warga">Status Tinggal</label>
                        <select name="status_warga" id="status_warga" required>
                            <option value="Tetap">Tetap</option>
                            <option value="Kontrak">Kontrak</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.2rem; font-size: 1rem;">Simpan Seluruh Data Keluarga</button>
        </div>

        <!-- Section: Data Anggota Keluarga -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="color: var(--secondary);">2. Anggota Keluarga</h3>
                <button type="button" onclick="addAnggota()" class="btn btn-ghost" style="font-size: 0.75rem; padding: 0.5rem 0.8rem;">+ Tambah Anggota</button>
            </div>

            <div id="anggota-container">
                <!-- Template Anggota (Akan diisi via JS) -->
            </div>
            
            <div id="empty-state" style="text-align: center; padding: 2rem 0; color: var(--text-muted); font-style: italic; font-size: 0.9rem;">
                Tidak ada anggota keluarga tambahan. Klik tombol di atas untuk menambah.
            </div>
        </div>

    </div>
</form>

<script>
    let anggotaCount = 0;

    function addAnggota() {
        document.getElementById('empty-state').style.display = 'none';
        
        const container = document.getElementById('anggota-container');
        const div = document.createElement('div');
        div.className = 'anggota-row fade-in';
        div.style.marginBottom = '1.5rem';
        div.style.padding = '1.25rem';
        div.style.borderRadius = '1rem';
        div.style.background = 'rgba(255,255,255,0.03)';
        div.style.border = '1px solid var(--border)';
        div.style.position = 'relative';

        div.innerHTML = `
            <button type="button" onclick="removeAnggota(this)" style="position: absolute; top: 0.5rem; right: 0.5rem; background: none; border: none; color: var(--danger); cursor: pointer; font-size: 1.25rem;">&times;</button>
            
            <div class="form-group">
                <label style="font-size: 0.75rem;">Nama Anggota Keluarga</label>
                <input type="text" name="anggota[${anggotaCount}][nama]" required placeholder="Nama Istri/Anak">
            </div>

            <div class="grid-mobile-stack" style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-top: 1rem;">
                <div class="form-group">
                    <label style="font-size: 0.75rem;">Hubungan</label>
                    <select name="anggota[${anggotaCount}][hubungan_keluarga]" required>
                        <option value="Istri">Istri</option>
                        <option value="Anak">Anak</option>
                        <option value="Orang Tua">Orang Tua</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="font-size: 0.75rem;">Jenis Kelamin</label>
                    <select name="anggota[${anggotaCount}][jenis_kelamin]" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-top: 1rem;">
                <label style="font-size: 0.75rem;">NIK (Opsional)</label>
                <input type="text" name="anggota[${anggotaCount}][nik]" placeholder="Nomor NIK">
            </div>
        `;

        container.appendChild(div);
        anggotaCount++;
    }

    function removeAnggota(btn) {
        btn.parentElement.remove();
        if (document.getElementById('anggota-container').children.length === 0) {
            document.getElementById('empty-state').style.display = 'block';
        }
    }
</script>
@endsection
