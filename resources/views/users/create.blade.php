@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('users.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Daftar</a>
    <h1 style="margin-top: 0.5rem; font-size: 2.5rem; font-weight: 800; letter-spacing: -1px;">Tambah Petugas Baru</h1>
    <p style="color: var(--text-muted);">Masukkan informasi akun petugas pengelola sistem.</p>
</div>

<div class="card" style="max-width: 600px; border-top: 4px solid var(--primary);">
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display: flex; gap: 2rem; align-items: flex-start; margin-bottom: 2rem;">
            <div style="flex: 1;">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="name">Nama Lengkap Petugas</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Andi Wijaya" style="width: 100%;">
                    @error('name') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email Login</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="contoh@wargasawit.id" style="width: 100%;">
                    @error('email') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="width: 180px;">
                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.8rem;">Foto Profil</label>
                <div id="photo-preview" style="width: 100%; height: 180px; background: rgba(255,255,255,0.03); border: 2px dashed var(--border); border-radius: 1.5rem; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; cursor: pointer;" onclick="document.getElementById('photo').click()">
                    <span style="color: var(--text-muted); font-size: 0.8rem; text-align: center; padding: 1rem;">Klik untuk pilih foto</span>
                    <img id="preview-img" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                </div>
                <input type="file" name="photo" id="photo" hidden accept="image/*" onchange="previewImage(this)">
                <p style="font-size: 0.65rem; color: var(--text-muted); margin-top: 0.5rem; text-align: center;">Max: 5MB (JPG/PNG)</p>
                @error('photo') <div style="color: var(--danger); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="password">Kata Sandi</label>
                <input type="password" name="password" id="password" required placeholder="Min. 8 karakter" style="width: 100%;">
                @error('password') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi sandi" style="width: 100%;">
            </div>
        </div>

        <div class="flex-mobile-stack" style="margin-top: 3rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 2; justify-content: center; padding: 1rem;">Simpan Petugas Baru</button>
            <a href="{{ route('users.index') }}" class="btn btn-ghost" style="flex: 1; justify-content: center;">Batal</a>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('preview-img').style.display = 'block';
                document.getElementById('photo-preview').querySelector('span').style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
