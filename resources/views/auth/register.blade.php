@extends('layouts.app')

@section('content')
<style>
/* --- GUNAKAN STYLE YANG SAMA DENGAN LOGIN AGAR SERAGAM --- */
:root {
    --pastel-purple-light: #E0C3FC;
    --pastel-purple-main: #A18CD1;
    --pastel-purple-dark: #8E44AD;
    --text-dark: #4A4A4A;
}

body {
    background: linear-gradient(135deg, var(--pastel-purple-light) 0%, #DCD6F7 100%);
    min-height: 100vh;
}
body::before {
    content: '';
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-color: rgba(161, 140, 209, 0.5);
    background-blend-mode: multiply;
    z-index: -1;
}

.auth-container {
    min-height: 85vh; /* Sedikit lebih tinggi karena form register panjang */
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
}

.auth-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 25px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    padding: 2.5rem;
    width: 100%;
    max-width: 500px; /* Sedikit lebih lebar */
    transition: transform 0.3s;
}
.auth-card:hover { transform: translateY(-5px); }

.auth-header { text-align: center; margin-bottom: 2rem; }
.auth-icon {
    width: 70px; height: 70px;
    background: linear-gradient(135deg, #A8E6CF, #1B5E20); /* Hijau Pastel untuk Register */
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin: 0 auto 15px auto;
    box-shadow: 0 5px 15px rgba(27, 94, 32, 0.3);
}
.auth-title { font-weight: 800; color: var(--pastel-purple-dark); font-size: 1.8rem; }
.auth-subtitle { color: #999; font-size: 0.9rem; }

.form-group { margin-bottom: 1.2rem; }
.form-label { font-weight: 700; color: var(--text-dark); font-size: 0.9rem; margin-left: 5px; }
.form-control-custom {
    border-radius: 12px;
    padding: 12px 15px;
    border: 1px solid #eee;
    background: #fdfdfd;
}
.form-control-custom:focus {
    border-color: var(--pastel-purple-main);
    box-shadow: 0 0 0 4px rgba(224, 195, 252, 0.3);
}

.btn-auth {
    background: linear-gradient(135deg, #11998e, #38ef7d); /* Gradien Hijau/Teal untuk Register */
    border: none;
    border-radius: 12px;
    padding: 12px;
    font-weight: 700;
    color: white;
    width: 100%;
    margin-top: 1rem;
    box-shadow: 0 5px 15px rgba(56, 239, 125, 0.3);
    transition: all 0.3s;
}
.btn-auth:hover { transform: scale(1.02); color: white; }

.auth-footer { text-align: center; margin-top: 1.5rem; font-size: 0.9rem; }
.auth-link { color: var(--pastel-purple-main); font-weight: 700; text-decoration: none; }
.auth-link:hover { text-decoration: underline; }
</style>

<div class="container auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h3 class="auth-title">Buat Akun Baru</h3>
            <p class="auth-subtitle">Bergabunglah dengan komunitas Lounge Game Room.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input id="name" type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Masukkan nama Anda">
                @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <input id="email" type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control form-control-custom @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                <input id="password-confirm" type="password" class="form-control form-control-custom" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password">
            </div>

            <button type="submit" class="btn btn-auth">
                DAFTAR SEKARANG <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </form>

        <div class="auth-footer">
            <span class="text-muted">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="auth-link">Login di sini</a>
        </div>
    </div>
</div>
@endsection