@extends('layouts.app')

@section('title', 'Daftar Reservasi')

@section('content')
<style>
/* --- PASTEL PURPLE THEME SETTINGS (Sama dengan Dashboard) --- */
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

/* Overlay Gambar Background */
body::before {
    content: '';
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-color: rgba(161, 140, 209, 0.4);
    background-blend-mode: soft-light;
    z-index: -1;
}

.content-wrapper {
    position: relative;
    z-index: 1;
    padding-top: 20px;
}

/* --- CARD STYLE (Glassmorphism) --- */
.reservation-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 25px rgba(161, 140, 209, 0.15);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.reservation-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(161, 140, 209, 0.3);
    border-color: var(--pastel-purple-light);
    background: #ffffff;
}

/* Image Area */
.card-img-top-container {
    height: 180px;
    position: relative;
    overflow: hidden;
}

.card-img-top-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.reservation-card:hover .card-img-top-container img {
    transform: scale(1.1);
}

.card-img-overlay-gradient {
    position: absolute;
    bottom: 0; left: 0; right: 0; top: 50%;
    background: linear-gradient(to top, rgba(74, 74, 74, 0.5), transparent);
    pointer-events: none;
}

/* Badge Status di Pojok Kanan Atas Gambar */
.status-badge-float {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    z-index: 2;
}

/* Warna-warni Pastel Status */
.badge-pending { background: #FFEAA7; color: #D35400; }   /* Kuning Pastel */
.badge-confirmed { background: #A8E6CF; color: #1B5E20; } /* Hijau Pastel */
.badge-completed { background: #74B9FF; color: #0984E3; } /* Biru Pastel */
.badge-cancelled { background: #FFB7B2; color: #C0392B; } /* Merah Pastel */

/* Body Content */
.reservation-card .card-body {
    padding: 1.5rem;
    flex: 1;
}

.booking-code {
    font-size: 0.8rem;
    letter-spacing: 1px;
    color: var(--pastel-purple-main);
    font-weight: 700;
    text-transform: uppercase;
    display: block;
    margin-bottom: 4px;
}

.room-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 1rem;
    line-height: 1.3;
}

/* Detail Grid */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    background: rgba(224, 195, 252, 0.15);
    padding: 12px;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.detail-item {
    font-size: 0.85rem;
    color: #636E72;
}
.detail-item i {
    color: var(--pastel-purple-main);
    width: 20px;
    margin-right: 4px;
}
.detail-value {
    display: block;
    font-weight: 700;
    color: var(--text-dark);
    margin-top: 2px;
}

/* Footer Action Buttons */
.card-footer-custom {
    padding: 1.25rem;
    border-top: 1px solid rgba(161, 140, 209, 0.1);
    background: transparent;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

/* Tombol Aksi Bulat */
.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border: none;
    font-size: 0.9rem;
    cursor: pointer;
}

.btn-action:hover { transform: translateY(-3px); }

/* Warna Tombol */
.btn-view { background: #DFE6E9; color: #636E72; }
.btn-view:hover { background: #B2BEC3; color: white; }

.btn-edit { background: #FFEAA7; color: #D35400; }
.btn-edit:hover { background: #FDCB6E; color: white; }

.btn-delete { background: #FFB7B2; color: #C0392B; }
.btn-delete:hover { background: #FF7675; color: white; }

.btn-confirm { background: #A8E6CF; color: #1B5E20; }
.btn-confirm:hover { background: #55EFC4; color: white; }

/* Header Page Style */
.page-header-card {
    background: linear-gradient(135deg, var(--pastel-purple-light) 0%, var(--pastel-purple-main) 100%);
    border-radius: 20px;
    padding: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(161, 140, 209, 0.3);
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}
.page-header-card::before {
    content: '';
    position: absolute;
    right: -50px; top: -50px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    filter: blur(40px);
}
</style>

<div class="content-wrapper container-fluid px-4">
    
    <div class="row">
        <div class="col-12">
            <div class="page-header-card d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <h2 class="font-weight-bold mb-1" style="text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fas fa-calendar-alt mr-2"></i> Daftar Reservasi
                    </h2>
                    <p class="mb-0 opacity-90">Kelola jadwal booking dan history permainan Anda di sini.</p>
                </div>
                
                @if(auth()->user()->isCustomer())
                <a href="{{ route('reservations.create') }}" class="btn shadow-sm" style="background: white; color: var(--pastel-purple-dark); font-weight: 700; border-radius: 12px; padding: 10px 25px;">
                    <i class="fas fa-plus-circle mr-2"></i> Buat Baru
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($reservations as $res)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card reservation-card">
                
                <div class="card-img-top-container">
                    <img src="{{ asset('storage/' . ($res->gameRoom->image ?? 'images/default-room.jpg')) }}" 
                         alt="{{ $res->gameRoom->name }}">
                    
                    <div class="card-img-overlay-gradient"></div>

                    @php
                        $badgeClass = match($res->status) {
                            'pending' => 'badge-pending',
                            'confirmed' => 'badge-confirmed',
                            'completed' => 'badge-completed',
                            'cancelled' => 'badge-cancelled',
                            default => 'bg-secondary text-white',
                        };
                    @endphp
                    <span class="status-badge-float {{ $badgeClass }}">
                        {{ ucfirst($res->status_label ?? $res->status) }}
                    </span>
                </div>

                <div class="card-body">
                    <span class="booking-code">#{{ $res->booking_code }}</span>
                    <h5 class="room-title">{{ $res->gameRoom->name }}</h5>
                    
                    @if(!auth()->user()->isCustomer())
                    <p class="text-muted small mb-3"><i class="fas fa-user mr-1"></i> Customer: <strong>{{ $res->user->name }}</strong></p>
                    @endif

                    <div class="detail-grid">
                        <div class="detail-item">
                            <i class="far fa-calendar-alt"></i> Tanggal
                            <span class="detail-value">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <i class="far fa-clock"></i> Jam
                            <span class="detail-value">{{ substr($res->start_time, 0, 5) }} - {{ substr($res->end_time, 0, 5) }}</span>
                        </div>
                        <div class="detail-item mt-2">
                            <i class="fas fa-hourglass-half"></i> Durasi
                            <span class="detail-value">{{ $res->duration_hours }} Jam</span>
                        </div>
                        <div class="detail-item mt-2">
                            <i class="fas fa-tag"></i> Total
                            <span class="detail-value text-primary" style="color: var(--pastel-purple-dark) !important;">{{ $res->formatted_total_price }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-footer-custom">
                    <a href="{{ route('reservations.show', $res->id) }}" class="btn-action btn-view" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </a>

                    @if(auth()->user()->isCustomer())
                        @if(in_array($res->status, ['pending', 'confirmed']))
                        <a href="{{ route('reservations.edit', $res->id) }}" class="btn-action btn-edit" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        @endif

                        @if($res->status === 'pending')
                        <form action="{{ route('reservations.cancel', $res->id) }}" method="POST" onsubmit="return confirm('Batalkan booking ini?')">
                            @csrf
                            <button type="submit" class="btn-action btn-delete" title="Batalkan">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                        @endif
                    @else
                    @if($res->status === 'pending')
                        <form action="{{ route('reservations.update-status', $res->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="btn-action btn-confirm" title="Terima Booking" onclick="return confirm('Konfirmasi booking ini?')">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        @endif
                    @endif
                    
                    @if(in_array($res->status, ['cancelled', 'completed']))
                    <form action="{{ route('reservations.destroy', $res->id) }}" method="POST" onsubmit="return confirm('Hapus history ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" style="background: #e2e8f0; color: #636e72;" title="Hapus Permanen">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>

            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="card border-0 shadow-sm" style="background: rgba(255,255,255,0.6); border-radius: 20px; padding: 3rem;">
                <i class="fas fa-calendar-times fa-4x mb-3" style="color: #cbd5e1;"></i>
                <h4 class="text-muted">Belum ada reservasi ditemukan.</h4>
                @if(auth()->user()->isCustomer())
                <a href="{{ route('reservations.create') }}" class="btn btn-link font-weight-bold" style="color: var(--pastel-purple-dark);">Mulai Booking Sekarang</a>
                @endif
            </div>
        </div>
        @endforelse
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{-- {{ $reservations->links() }} --}} 
    </div>
</div>
@endsection