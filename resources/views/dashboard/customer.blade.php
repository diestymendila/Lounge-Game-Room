@extends('layouts.app')

@section('title', 'Dashboard Customer')

@section('content')
<style>
/* --- PASTEL PURPLE THEME SETTINGS --- */
:root {
    --pastel-purple-light: #E0C3FC; /* Ungu Muda Cerah */
    --pastel-purple-main: #A18CD1;  /* Ungu Muda Sedang */
    --pastel-purple-dark: #8E44AD;  /* Ungu untuk teks/aksen */
    --pastel-bg: #F8F4FF;           /* Latar belakang sangat muda */
    --text-dark: #4A4A4A;           /* Teks gelap agar kontras */
}

/* Background Utama dengan Gambar dan Gradien Ungu Muda */
body {
    background: linear-gradient(135deg, var(--pastel-purple-light) 0%, #DCD6F7 100%);
    background-attachment: fixed;
    color: var(--text-dark);
    position: relative;
}

/* Gambar Latar Belakang dengan Overlay Ungu Muda */
body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* Gambar Background Gaming (Ganti URL jika perlu) */
    background-image: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    /* Overlay Ungu Muda Transparan agar gambar terlihat lembut */
    background-color: rgba(161, 140, 209, 0.4); /* Warna #A18CD1 dengan transparansi */
    background-blend-mode: soft-light; /* Mode blend agar menyatu halus */
    z-index: -1;
}

.content-wrapper {
    position: relative;
    z-index: 1;
    padding-top: 20px;
}

/* --- CARDS STYLING (Glassmorphism Halus) --- */
.game-room-card {
    background: rgba(255, 255, 255, 0.85); /* Latar belakang semi-transparan */
    backdrop-filter: blur(15px);           /* Efek blur kaca */
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 25px rgba(161, 140, 209, 0.15); /* Shadow ungu muda lembut */
    height: 100%;
    display: flex;
    flex-direction: column;
}

.game-room-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(161, 140, 209, 0.3);
    border-color: var(--pastel-purple-light);
    background: rgba(255, 255, 255, 0.95);
}

/* Image Container */
.room-image-container {
    position: relative;
    width: 100%;
    height: 240px;
    overflow: hidden;
}

/* Overlay gambar dengan gradien ungu muda */
.room-image-container::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(to top, rgba(142, 68, 173, 0.3), transparent 60%); /* Aksen ungu di bawah */
    z-index: 1;
}

.room-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.game-room-card:hover .room-image-container img {
    transform: scale(1.1);
}

/* --- BADGES (Pastel Colors) --- */
.status-badge-overlay {
    position: absolute;
    top: 16px;
    right: 16px;
    z-index: 2;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Warna Pastel Hijau & Merah */
.status-badge-overlay.available {
    background: #A8E6CF; /* Pastel Mint */
    color: #1B5E20;
}

.status-badge-overlay.maintenance {
    background: #FFB7B2; /* Pastel Salmon */
    color: #B71C1C;
}

/* --- TYPOGRAPHY & BODY --- */
.game-room-card .card-body {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.game-room-card .card-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--pastel-purple-dark); /* Teks Judul Ungu Gelap */
    margin-bottom: 0.5rem;
}

.game-room-card .card-text {
    color: #6C757D; /* Teks Deskripsi Abu-abu */
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 1.25rem;
}

/* Info List Style */
.room-info-list {
    list-style: none;
    padding: 0;
    margin: 0;
    background: rgba(224, 195, 252, 0.15); /* Latar list ungu sangat muda */
    border-radius: 12px;
    padding: 1rem;
}

.room-info-list li {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
    color: #6C757D;
    font-size: 0.9rem;
}

.room-info-list li i {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--pastel-purple-light); /* Ikon background ungu muda */
    color: var(--pastel-purple-dark); /* Ikon warna ungu gelap */
    border-radius: 50%;
    margin-right: 12px;
    font-size: 0.8rem;
}

.room-info-list li strong {
    color: var(--pastel-purple-dark);
    font-weight: 700;
    margin-left: 4px;
}

/* --- BUTTONS (Gradient Ungu Muda) --- */
.game-room-card .card-footer {
    padding: 1.25rem;
    background: transparent;
    border-top: 1px solid rgba(161, 140, 209, 0.1);
}

.btn-reserve {
    width: 100%;
    padding: 0.8rem 1.5rem;
    font-weight: 700;
    border-radius: 15px;
    border: none;
    transition: all 0.3s ease;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 1px;
    color: white;
    box-shadow: 0 4px 15px rgba(161, 140, 209, 0.4);
}

/* Gradien Ungu Muda ke Sedang */
.btn-reserve.btn-primary {
    background: linear-gradient(135deg, var(--pastel-purple-main) 0%, var(--pastel-purple-light) 100%);
}

.btn-reserve.btn-primary:hover {
    background: linear-gradient(135deg, var(--pastel-purple-dark) 0%, var(--pastel-purple-main) 100%);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(161, 140, 209, 0.6);
}

.btn-reserve.btn-secondary {
    background: #E2E8F0;
    color: #94A3B8;
    box-shadow: none;
}

/* --- WELCOME HEADER CARD --- */
.welcome-card {
    /* Gradien Ungu Muda Cerah */
    background: linear-gradient(135deg, var(--pastel-purple-light) 0%, var(--pastel-purple-main) 100%);
    border: none;
    border-radius: 20px;
    color: var(--pastel-purple-dark); /* Teks ungu gelap agar kontras */
    box-shadow: 0 10px 30px rgba(161, 140, 209, 0.3);
    position: relative;
    overflow: hidden;
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: -50%; right: -20%;
    width: 300px; height: 300px;
    background: rgba(255, 255, 255, 0.3); /* Aksen putih transparan */
    border-radius: 50%;
    filter: blur(50px);
}

.welcome-card h4 {
    font-weight: 800;
    color: #FFFFFF; /* Judul Putih */
    text-shadow: 0 2px 4px rgba(142, 68, 173, 0.2);
}
.welcome-card p {
    color: #F8F4FF; /* Teks Putih Gading */
}

/* --- SECTION TITLE --- */
.section-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--pastel-purple-dark); /* Dark Lavender */
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 15px;
}

.section-title i {
    background: linear-gradient(135deg, var(--pastel-purple-light), var(--pastel-purple-main));
    padding: 10px;
    border-radius: 12px;
    color: white;
    font-size: 1.2rem;
    box-shadow: 0 4px 10px rgba(161, 140, 209, 0.4);
}

/* --- TABLE SECTION --- */
.table-section {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 40px rgba(161, 140, 209, 0.1);
    overflow: hidden;
}

.table-section .card-header {
    background: rgba(224, 195, 252, 0.2); /* Header ungu sangat muda */
    border-bottom: 1px solid rgba(161, 140, 209, 0.1);
    padding: 1.5rem;
}

.table-section .card-header h5 {
    color: var(--pastel-purple-dark);
    font-weight: 800;
}

.table-modern thead {
    background: rgba(224, 195, 252, 0.3);
}

.table-modern thead th {
    color: var(--pastel-purple-dark);
    font-weight: 800;
    text-transform: uppercase;
    font-size: 0.8rem;
    border: none;
    padding: 1rem;
}

.table-modern tbody tr:hover {
    background-color: rgba(224, 195, 252, 0.1);
}

.table-modern td {
    color: #555;
    padding: 1rem;
    vertical-align: middle;
    border-top: 1px solid rgba(161, 140, 209, 0.05);
}

/* Responsive */
@media (max-width: 768px) {
    .room-image-container { height: 200px; }
    .section-title { font-size: 1.5rem; }
}
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card welcome-card mb-5">
                <div class="card-body p-4 p-md-5">
                    <h4 class="mb-2">
                        <i class="fas fa-gamepad mr-2"></i> 
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h4>
                    <p class="mb-0 opacity-90" style="font-size: 1.05rem; font-weight: 500;">
                        Anda login sebagai <strong>Customer</strong>. Pilih ruangan game favorit Anda dan mulai petualangan gaming terbaik!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <h4 class="section-title">
                <i class="fas fa-fire"></i>
                Ruangan Game Tersedia
            </h4>
        </div>
        @forelse($gameRooms as $room)
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card game-room-card">
                <div class="room-image-container">
                    @if($room->image)
                    <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}">
                    @else
                    <div class="d-flex align-items-center justify-content-center h-100" style="background: #E2E8F0;">
                        <i class="fas fa-gamepad fa-3x text-white"></i>
                    </div>
                    @endif
                    
                    <span class="status-badge-overlay {{ $room->status === 'available' ? 'available' : 'maintenance' }}">
                        @if($room->status === 'available')
                        <i class="fas fa-check-circle mr-1"></i> Tersedia
                        @else
                        <i class="fas fa-tools mr-1"></i> Maintenance
                        @endif
                    </span>
                </div>
                
                <div class="card-body">
                    <h5 class="card-title">{{ $room->name }}</h5>
                    <p class="card-text">{{ Str::limit($room->description, 70) }}</p>
                    
                    <ul class="room-info-list">
                        <li>
                            <i class="fas fa-users"></i>
                            <span>Kapasitas <strong>{{ $room->capacity }} orang</strong></span>
                        </li>
                        <li>
                            <i class="fas fa-tag"></i>
                            <span><strong>{{ $room->formatted_price }}</strong>/jam</span>
                        </li>
                    </ul>
                </div>
                
                <div class="card-footer">
                    @if($room->status === 'available')
                    <a href="{{ route('reservations.create', ['game_room_id' => $room->id]) }}" class="btn btn-reserve btn-primary">
                        Reservasi
                    </a>
                    @else
                    <button class="btn btn-reserve btn-secondary" disabled>
                        Tidak Tersedia
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-light shadow-sm border-0 p-4 text-center rounded-lg" style="background: rgba(255,255,255,0.8);">
                <i class="fas fa-info-circle text-muted mr-2"></i> Belum ada ruangan game tersedia.
            </div>
        </div>
        @endforelse
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card table-section">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history mr-2" style="color: var(--pastel-purple-dark);"></i> 
                        Reservasi Terakhir Saya
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($myReservations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Ruangan</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myReservations as $reservation)
                                <tr>
                                    <td><span class="badge badge-light border" style="color: var(--pastel-purple-dark);">{{ $reservation->booking_code }}</span></td>
                                    <td><strong style="color: var(--pastel-purple-dark);">{{ $reservation->gameRoom->name }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d/m/Y') }}</td>
                                    <td>{{ substr($reservation->start_time, 0, 5) }} - {{ substr($reservation->end_time, 0, 5) }}</td>
                                    <td class="font-weight-bold" style="color: var(--pastel-purple-dark);">{{ $reservation->formatted_total_price }}</td>
                                    <td>
                                        @php
                                            $badgeColor = match($reservation->status) {
                                                'pending' => '#FFEAA7', // Pastel Yellow
                                                'confirmed' => '#A8E6CF', // Pastel Green
                                                'completed' => '#74B9FF', // Pastel Blue
                                                'cancelled' => '#FFB7B2', // Pastel Red
                                                default => '#DFE6E9',
                                            };
                                            $textColor = match($reservation->status) {
                                                'pending' => '#D35400',
                                                'confirmed' => '#2D3436',
                                                'completed' => '#2D3436',
                                                'cancelled' => '#C0392B',
                                                default => '#636E72',
                                            };
                                        @endphp
                                        <span class="badge" style="background-color: {{ $badgeColor }}; color: {{ $textColor }}; border-radius: 10px; padding: 0.5em 1em;">
                                            {{ ucfirst($reservation->status_label ?? $reservation->status) }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm btn-light border" title="Detail" style="color: var(--pastel-purple-dark);">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-center p-4">
                        <a href="{{ route('reservations.index') }}" class="btn btn-link text-decoration-none" style="color: var(--pastel-purple-dark); font-weight: 700;">
                            Lihat Semua Reservasi <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x mb-3" style="color: #CBD5E1;"></i>
                        <p class="text-muted">Anda belum memiliki reservasi.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection