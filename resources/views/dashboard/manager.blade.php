@extends('layouts.app')

@section('title', 'Dashboard Manager')

@section('content')
<style>
/* --- TEMA SERAGAM (Sama dengan Customer) --- */
:root {
    --pastel-purple-light: #E0C3FC;
    --pastel-purple-main: #A18CD1;
    --pastel-purple-dark: #8E44AD;
    --pastel-bg: #F8F4FF;
    --text-dark: #4A4A4A;
}

/* Background Utama */
body {
    background: linear-gradient(135deg, var(--pastel-purple-light) 0%, #DCD6F7 100%);
    background-attachment: fixed;
    color: var(--text-dark);
}

/* Overlay Gambar Background (Sama dengan Customer) */
body::before {
    content: '';
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    /* Gambar Setup Gaming Putih/Bersih */
    background-image: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-color: rgba(161, 140, 209, 0.4); /* Overlay ungu muda transparan */
    background-blend-mode: soft-light;
    z-index: -1;
}

.content-wrapper {
    padding-top: 20px;
}

/* --- KARTU HEADER (Banner) --- */
.welcome-card {
    /* Gradien Ungu Muda Cerah (Sama dengan Banner Customer) */
    background: linear-gradient(135deg, var(--pastel-purple-light) 0%, var(--pastel-purple-main) 100%);
    border: none;
    border-radius: 20px;
    color: var(--pastel-purple-dark);
    box-shadow: 0 10px 30px rgba(161, 140, 209, 0.3);
    position: relative;
    overflow: hidden;
    padding: 2.5rem;
    margin-bottom: 2rem;
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: -50%; right: -20%;
    width: 300px; height: 300px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    filter: blur(50px);
}

.welcome-card h4 {
    font-weight: 800;
    color: white;
    text-shadow: 0 2px 4px rgba(142, 68, 173, 0.2);
    margin-bottom: 10px;
}
.welcome-card p {
    color: #F8F4FF;
    font-size: 1.1rem;
    font-weight: 500;
}

/* --- KARTU STATISTIK (Glassmorphism) --- */
.stats-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 20px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(161, 140, 209, 0.15);
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    background: #ffffff;
    box-shadow: 0 15px 35px rgba(161, 140, 209, 0.25);
}

.stats-info h6 {
    color: #95a5a6;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
}

.stats-info h3 {
    color: var(--text-dark);
    font-weight: 800;
    font-size: 1.8rem;
    margin: 0;
}

/* Icon Bulat */
.icon-box {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Warna Icon Pastel */
.bg-purple { background: linear-gradient(135deg, #E0C3FC, #8E44AD); }
.bg-orange { background: linear-gradient(135deg, #FFE082, #FFB74D); }
.bg-green  { background: linear-gradient(135deg, #A5D6A7, #66BB6A); }
.bg-blue   { background: linear-gradient(135deg, #90CAF9, #42A5F5); }

/* --- SECTON TITLE --- */
.section-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--pastel-purple-dark);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.section-title i {
    background: var(--pastel-purple-light);
    color: var(--pastel-purple-dark);
    padding: 8px;
    border-radius: 10px;
    font-size: 1rem;
}

/* --- TABEL ADMIN (Sama dengan Riwayat Customer) --- */
.table-container {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 40px rgba(161, 140, 209, 0.1);
    padding: 1.5rem;
    height: 100%;
}

.table-custom thead th {
    background: rgba(224, 195, 252, 0.3);
    color: var(--pastel-purple-dark);
    font-weight: 800;
    text-transform: uppercase;
    font-size: 0.8rem;
    border: none;
    padding: 1rem;
    border-radius: 10px;
}

.table-custom tbody td {
    padding: 1rem;
    vertical-align: middle;
    color: #555;
    border-bottom: 1px solid rgba(161, 140, 209, 0.1);
}

/* --- TOMBOL AKSI CEPAT --- */
.action-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 10px 40px rgba(161, 140, 209, 0.1);
    margin-bottom: 2rem;
}

.btn-quick {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    border-radius: 15px;
    font-weight: 700;
    color: white;
    text-decoration: none;
    transition: all 0.3s;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border: none;
    width: 100%;
}
.btn-quick:hover { transform: translateY(-3px); color: white; opacity: 0.9; }

/* Warna Tombol Senada */
.btn-add-room { background: linear-gradient(135deg, #A18CD1, #8E44AD); } /* Ungu */
.btn-manage   { background: linear-gradient(135deg, #4DB6AC, #009688); } /* Teal Pastel */
.btn-history  { background: linear-gradient(135deg, #FFB74D, #F57C00); } /* Orange Pastel */

</style>

<div class="content-wrapper container-fluid px-4">

    <div class="row">
        <div class="col-12">
            <div class="welcome-card">
                <h4><i class="fas fa-crown mr-2"></i> Dashboard Manager</h4>
                <p class="mb-0">Halo, <strong>{{ Auth::user()->name }}</strong>! Kelola bisnis lounge game Anda dengan mudah dan elegan.</p>
            </div>
        </div>
    </div>

    <div class="row mb-4 g-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-info">
                    <h6>Total Ruangan</h6>
                    <h3>{{ $totalRooms ?? 0 }}</h3>
                </div>
                <div class="icon-box bg-purple">
                    <i class="fas fa-gamepad"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-info">
                    <h6>Total Reservasi</h6>
                    <h3>{{ $totalReservations ?? 0 }}</h3>
                </div>
                <div class="icon-box bg-orange">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-info">
                    <h6>Pendapatan</h6>
                    <h3 style="font-size: 1.5rem;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="icon-box bg-green">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-info">
                    <h6>Customer</h6>
                    <h3>{{ $totalCustomers ?? 0 }}</h3>
                </div>
                <div class="icon-box bg-blue">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="action-card h-100">
                <h5 class="section-title">
                    <i class="fas fa-bolt"></i> Aksi Cepat
                </h5>
                <div class="d-grid gap-3">
                    <a href="{{ route('game-rooms.create') }}" class="btn-quick btn-add-room">
                        <i class="fas fa-plus-circle mr-2"></i> Tambah Ruangan
                    </a>
                    <a href="{{ route('game-rooms.index') }}" class="btn-quick btn-manage">
                        <i class="fas fa-edit mr-2"></i> Kelola Ruangan
                    </a>
                    <a href="{{ route('reservations.index') }}" class="btn-quick btn-history">
                        <i class="fas fa-list-alt mr-2"></i> Semua Reservasi
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0">
                        <i class="fas fa-chart-pie"></i> Statistik Ruangan
                    </h5>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Ruangan</th>
                                <th>Harga/Jam</th>
                                <th class="text-center">Total Booking</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rooms as $room)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width: 45px; height: 45px; border-radius: 50%; overflow: hidden; margin-right: 15px; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                            <img src="{{ asset('storage/' . $room->image) }}" style="width:100%; height:100%; object-fit:cover;">
                                        </div>
                                        <span class="font-weight-bold" style="color: var(--text-dark);">{{ $room->name }}</span>
                                    </div>
                                </td>
                                <td class="font-weight-bold" style="color: var(--pastel-purple-dark);">Rp {{ number_format($room->price_per_hour, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge" style="background: #E3F2FD; color: #1565C0; border-radius: 10px; padding: 5px 10px;">
                                        {{ $room->reservations_count }} kali
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($room->status == 'available')
                                        <span class="badge" style="background: #C8E6C9; color: #2E7D32; border-radius: 10px; padding: 5px 10px;">Tersedia</span>
                                    @else
                                        <span class="badge" style="background: #FFCDD2; color: #C62828; border-radius: 10px; padding: 5px 10px;">Maintenance</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                    Tidak ada data ruangan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection