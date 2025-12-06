@extends('layouts.app')

@section('content')
<style>
/* --- AUTH PAGE STYLE --- */
:root {
    --pastel-purple-light: #E0C3FC;
    --pastel-purple-main: #A18CD1;
    --pastel-purple-dark: #8E44AD;
    --text-dark: #4A4A4A;
}

/* Background Full Screen */
body {
    background: linear-gradient(135deg, var(--pastel-purple-light) 0%, #DCD6F7 100%);
    min-height: 100vh;
}

body::before {
    content: '';
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    /* Gambar sama dengan dashboard */
    background-image: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-color: rgba(161, 140, 209, 0.5); /* Overlay Ungu */
    background-blend-mode: multiply;
    z-index: -1;
}

/* Container Tengah */
.auth-container {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Kartu Glassmorphism */
.auth-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 25px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    overflow: hidden;
    padding: 2.5rem;
    width: 100%;
    max-width: 450px;
    transition: transform 0.3s;
}

.auth-card:hover {
    transform: translateY(-5px);
}

/* Header & Icon */
.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}
.auth-icon {
    width: 70px; height: 70px;
    background: linear-gradient(135deg, var(--pastel-purple-light), var(--pastel-purple-main));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin: 0 auto 15px auto;
    box-shadow: 0 5px 15px rgba(161, 140, 209, 0.4);
}
.auth-title {
    font-weight: 800;
    color: var(--pastel-purple-dark);
    font-size: 1.8rem;
}
.auth-subtitle {
    color: #999;
    font-size: 0.9rem;
}

/* Form Input */
.form-group { margin-bottom: 1.2rem; }
.form-label {
    font-weight: 700;
    color: var(--text-dark);
    font-size: 0.9rem;
    margin-left: 5px;
}
.form-control-custom {
    border-radius: 12px;
    padding: 12px 15px;
    border: 1px solid #eee;
    background: #fdfdfd;
    transition: all 0.3s;
}
.form-control-custom:focus {
    border-color: var(--pastel-purple-main);
    box-shadow: 0 0 0 4px rgba(224, 195, 252, 0.3);
}

/* Tombol Login */
.btn-auth {
    background: linear-gradient(135deg, var(--pastel-purple-main) 0%, var(--pastel-purple-dark) 100%);
    border: none;
    border-radius: 12px;
    padding: 12px;
    font-weight: 700;
    color: white;
    width: 100%;
    margin-top: 1rem;
    box-shadow: 0 5px 15px rgba(161, 140, 209, 0.4);
    transition: all 0.3s;
}
.btn-auth:hover {
    transform: scale(1.02);
    color: white;
    box-shadow: 0 8px 20px rgba(161, 140, 209, 0.6);
}

/* Link Bawah */
.auth-footer {
    text-align: center;
    margin-top: 1.5rem;
    font-size: 0.9rem;
}
.auth-link {
    color: var(--pastel-purple-main);
    font-weight: 700;
    text-decoration: none;
}
.auth-link:hover { text-decoration: underline; color: var(--pastel-purple-dark); }
</style>

<div class="container auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-gamepad"></i>
            </div>
            <h3 class="auth-title">Welcome Back!</h3>
            <p class="auth-subtitle">Silakan login untuk masuk ke Lounge.</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <div class="d-flex justify-content-between">
                    <label for="password" class="form-label">Password</label>
                    @if (Route::has('password.request'))
                        <a class="auth-link" style="font-size: 0.8rem;" href="{{ route('password.request') }}">Lupa Password?</a>
                    @endif
                </div>
                <input id="password" type="password" class="form-control form-control-custom @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-muted" for="remember">
                        Ingat Saya
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-auth">
                LOGIN <i class="fas fa-sign-in-alt ml-2"></i>
            </button>
        </form>

        <div class="auth-footer">
            <span class="text-muted">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="auth-link">Daftar Sekarang</a>
        </div>
    </div>
</div>
@endsection