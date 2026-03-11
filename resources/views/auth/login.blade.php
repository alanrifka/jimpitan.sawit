<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SI Warga Sawit RT 02</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(rgba(2, 6, 23, 0.7), rgba(2, 6, 23, 0.85)), url('{{ asset('images/sawit.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.03); /* Lebih transparan */
            backdrop-filter: blur(40px); /* Blur lebih kuat untuk efek kaca */
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 3rem;
            padding: 4rem;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.8);
            animation: cardEntrance 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
            position: relative;
            z-index: 10;
        }

        @keyframes cardEntrance {
            from { opacity: 0; transform: scale(0.9) translateY(30px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-img {
            width: 90px;
            height: 90px;
            border-radius: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 15px 30px rgba(0,0,0,0.4);
            border: 2px solid rgba(255, 255, 255, 0.15);
            padding: 5px;
            background: rgba(255, 255, 255, 0.05);
        }

        .brand-name {
            font-size: 1.75rem;
            font-weight: 800;
            color: white;
            letter-spacing: -1px;
            margin-bottom: 0.25rem;
        }

        .brand-sub {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .form-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.75rem;
        }

        .form-group input {
            width: 100%;
            padding: 1.2rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.25rem;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
        }

        .btn-login {
            width: 100%;
            padding: 1.3rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 1.25rem;
            color: white;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(99, 102, 241, 0.6);
            filter: brightness(1.1);
        }

        .error-box {
            background: rgba(244, 63, 94, 0.15);
            border-left: 4px solid #f43f5e;
            color: #fda4af;
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
            font-size: 0.85rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @media (max-width: 480px) {
            .login-card { padding: 2.5rem; margin: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo-container">
            <img src="{{ asset('images/sawit.png') }}" class="logo-img" alt="Logo Sawit">
            <h1 class="brand-name">SI WARGA SAWIT</h1>
            <p class="brand-sub">RT 02 PANGGUNGHARJO</p>
        </div>

        @if($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Petugas</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="admin@wargasawit.id" autofocus>
            </div>

            <div class="form-group" style="margin-top: 1.5rem;">
                <label for="password">Kata Sandi</label>
                <input type="password" name="password" id="password" required placeholder="••••••••">
            </div>

            <div style="margin-top: 2.5rem;">
                <button type="submit" class="btn-login">MASUK KE DASHBOARD</button>
            </div>
        </form>

        <div style="text-align: center; margin-top: 2.5rem; color: rgba(255,255,255,0.3); font-size: 0.75rem; font-weight: 600; letter-spacing: 1px;">
            PEMERINTAH DESA PANGGUNGHARJO
        </div>
    </div>
</body>
</html>
