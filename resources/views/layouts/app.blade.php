<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lounge Game Room') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* --- GLOBAL PASTEL THEME --- */
        :root {
            --pastel-purple-light: #E0C3FC;
            --pastel-purple-main: #A18CD1;
            --pastel-bg: #F8F4FF;
            --text-dark: #4A4A4A;
        }

        body {
            background: linear-gradient(135deg, var(--pastel-purple-light) 0%, #DCD6F7 100%);
            background-attachment: fixed;
            font-family: 'Nunito', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* --- NAVBAR FLOATING STYLE --- */
        .navbar-floating {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px rgba(161, 140, 209, 0.15);
            margin: 20px 20px 0 20px; /* Jarak atas/kiri/kanan */
            border-radius: 20px;
            padding: 0.8rem 1.5rem;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #8E44AD 0%, #A18CD1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            color: #636E72 !important;
            font-weight: 600;
            margin: 0 5px;
            padding: 8px 16px !important;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #8E44AD !important;
            background: rgba(224, 195, 252, 0.3);
            transform: translateY(-2px);
        }

        /* User Profile Button */
        .nav-user-btn {
            background: linear-gradient(135deg, #E0C3FC 0%, #DCD6F7 100%);
            color: #5E548E !important;
            padding: 8px 20px !important;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Content Wrapper - Penting agar tidak tertutup navbar */
        .py-4 {
            padding-top: 30px !important; 
        }
        
        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(161, 140, 209, 0.2);
            padding: 0.5rem;
            margin-top: 10px;
        }
        .dropdown-item {
            border-radius: 10px;
            padding: 8px 16px;
        }
        .dropdown-item:hover {
            background-color: #F3E7FC;
            color: #8E44AD;
        }
    </style>
</head>
<body>
    <div id="app">
        
        <nav class="navbar navbar-expand-md navbar-light fixed-top navbar-floating">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-gamepad me-2" style="color: #A18CD1;"></i>
                    Lounge Game Room
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-home me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('reservations*') ? 'active' : '' }}" href="{{ route('reservations.index') }}">
                                <i class="fas fa-calendar-alt me-1"></i> Reservasi
                            </a>
                        </li>
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle nav-user-btn" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle fa-lg"></i> 
                                    <span>{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user me-2 text-muted"></i> Profil Saya
                                    </a>
                                    
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4" style="margin-top: 100px;">
            @yield('content')
        </main>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>