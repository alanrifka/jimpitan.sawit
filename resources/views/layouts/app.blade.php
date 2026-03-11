<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SI Warga Sawit' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom scrollbar for premium feel */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--background); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }
    </style>
</head>
<body>
    <nav>
        <div>
            <div class="nav-brand">SI WARGA SAWIT RT 02</div>
            <div style="font-size: 0.65rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; margin-top: -4px;">PANGGUNGHARJO, SEWON, BANTUL</div>
        </div>
        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">DASHBOARD</a>
            <a href="{{ route('wargas.index') }}" class="{{ request()->routeIs('wargas.*') ? 'active' : '' }}">WARGA</a>
            <a href="{{ route('rumahs.index') }}" class="{{ request()->routeIs('rumahs.*') ? 'active' : '' }}">RUMAH</a>
            <a href="{{ route('jimpitans.index') }}" class="{{ request()->routeIs('jimpitans.*') ? 'active' : '' }}">IURAN JIMPITAN</a>
            <a href="{{ route('kas-masuks.index') }}" class="{{ request()->routeIs('kas-masuks.*') ? 'active' : '' }}">KAS MASUK</a>
            <a href="{{ route('pengeluarans.index') }}" class="{{ request()->routeIs('pengeluarans.*') ? 'active' : '' }}">KAS KELUAR</a>
            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">PETUGAS</a>
            <a href="{{ route('cctv.index') }}" class="{{ request()->routeIs('cctv.*') ? 'active' : '' }}" style="{{ request()->routeIs('cctv.*') ? '' : 'color: #f87171;' }}">📹 CCTV</a>
        </div>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                @if(auth()->user()->photo)
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" style="width: 32px; height: 32px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border);">
                @else
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 8px;"></div>
                @endif
                <span style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted)">{{ auth()->user()->name }}</span>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-ghost" style="padding: 0.5rem 1rem; font-size: 0.8rem; border-color: rgba(244, 63, 94, 0.2); color: var(--danger);">KELUAR</button>
            </form>
        </div>
    </nav>

    <main class="container fade-in">
        @if(session('success'))
            <div class="card" style="margin-bottom: 2rem; border-color: var(--success); background: var(--success-glow); padding: 1rem 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <span style="font-size: 1.25rem;">✅</span>
                <span style="color: var(--text); font-weight: 600;">{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer style="margin-top: 5rem; padding: 2rem; text-align: center; border-top: 1px solid var(--border);">
        <p style="color: var(--text-muted); font-size: 0.8rem;">&copy; {{ date('Y') }}  • Sistem Manajemen Warga Sawit RT 02 Modern</p>
    </footer>
</body>
</html>
