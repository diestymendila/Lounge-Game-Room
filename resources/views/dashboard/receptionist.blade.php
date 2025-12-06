@extends('layouts.app')

@section('title', 'Dashboard Resepsionis')

@section('content')
<style>
/* --- TEMA PASTEL SERAGAM --- */
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
    /* Gambar Setup Gaming Putih/Bersih */
    background-image: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-color: rgba(161, 140, 209, 0.4); 
    background-blend-mode: soft-light;
    z-index: -1;
}

.content-wrapper {
    padding-top: 20px;
}

/* --- HEADER CARD --- */
.welcome-card {
    background: linear-gradient(135deg, var(--pastel-purple-light) 0%, var(--pastel-purple-main) 100%);
    border-radius: 20px;
    padding: 2.5rem;
    color: white;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(161, 140, 209, 0.3);
    position: relative;
    overflow: hidden;
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
    text-shadow: 0 2px 4px rgba(142, 68, 173, 0.2);
}

/* --- SECTION CARD & TABLE --- */
.section-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(161, 140, 209, 0.15);
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.6);
}

.section-title {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--pastel-purple-dark);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.icon-title {
    background: var(--pastel-purple-light);
    color: var(--pastel-purple-dark);
    width: 40px; height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

/* Table Styling */
.table-custom thead th {
    background: rgba(224, 195, 252, 0.3);
    color: var(--pastel-purple-dark);
    font-weight: 800;
    text-transform: uppercase;
    font-size: 0.8rem;
    border: none;
    padding: 1rem;
    border-radius: 8px;
}

.table-custom tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(161, 140, 209, 0.1);
    color: #555;
    font-size: 0.95rem;
}

.booking-code {
    font-family: 'Courier New', monospace;
    font-weight: 700;
    color: var(--pastel-purple-dark);
    background: #F3E7FC;
    padding: 4px 8px;
    border-radius: 6px;
}

/* Tombol Aksi */
.btn-action {
    width: 35px; height: 35px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: all 0.2s;
    color: white;
}
.btn-action:hover { transform: scale(1.1); }

.btn-confirm { background: linear-gradient(135deg, #4DB6AC, #009688); } /* Teal */
.btn-detail  { background: linear-gradient(135deg, #90CAF9, #1E88E5); } /* Blue */
.btn-cancel  { background: linear-gradient(135deg, #EF9A9A, #E53935); } /* Red */

</style>

<div class="content-wrapper container-fluid px-4">

    <div class="row">
        <div class="col-12">
            <div class="welcome-card">
                <h4><i class="fas fa-headset mr-2"></i> Dashboard Resepsionis</h4>
                <p class="mb-0">Halo, <strong>{{ Auth::user()->name }}</strong>. Kelola kedatangan pelanggan dan konfirmasi reservasi hari ini.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="section-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0">
                        <div class="icon-title"><i class="fas fa-clock"></i></div>
                        Menunggu Konfirmasi
                    </h5>
                    @if(isset($pendingReservations) && $pendingReservations->count() > 0)
                        <span class="badge badge-warning text-white px-3 py-2 rounded-pill" style="background: #FFB74D;">
                            {{ $pendingReservations->count() }} Permintaan Baru
                        </span>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Customer</th>
                                <th>Ruangan</th>
                                <th>Waktu Main</th>
                                <th>Total</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingReservations as $res)
                            <tr>
                                <td><span class="booking-code">{{ $res->booking_code }}</span></td>
                                <td>
                                    <div class="font-weight-bold">{{ $res->user->name }}</div>
                                    <small class="text-muted"><i class="fas fa-phone-alt mr-1"></i> {{ $res->user->phone ?? '-' }}</small>
                                </td>
                                <td>{{ $res->gameRoom->name }}</td>
                                <td>
                                    <div class="text-dark font-weight-bold">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}</div>
                                    <small>{{ substr($res->start_time, 0, 5) }} - {{ substr($res->end_time, 0, 5) }}</small>
                                </td>
                                <td class="font-weight-bold" style="color: var(--pastel-purple-dark);">{{ $res->formatted_total_price }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('reservations.update-status', $res->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn-action btn-confirm" title="Terima Booking" onclick="return confirm('Terima reservasi ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        
                                        <a href="{{ route('reservations.show', $res->id) }}" class="btn-action btn-detail" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <form action="{{ route('reservations.cancel', $res->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-action btn-cancel" title="Tolak" onclick="return confirm('Tolak reservasi ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-check-circle fa-2x text-muted mb-3 d-block" style="color: #A5D6A7 !important;"></i>
                                    <span class="text-muted">Tidak ada reservasi baru yang menunggu.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="section-card">
                <h5 class="section-title">
                    <div class="icon-title"><i class="fas fa-calendar-day"></i></div>
                    Jadwal Hari Ini ({{ \Carbon\Carbon::now()->format('d M Y') }})
                </h5>

                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Jam</th>
                                <th>Ruangan</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayReservations as $today)
                            <tr>
                                <td>
                                    <span class="badge badge-light border px-2 py-1" style="font-size: 0.9rem;">
                                        {{ substr($today->start_time, 0, 5) }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $today->gameRoom->name }}</strong>
                                </td>
                                <td>{{ $today->user->name }}</td>
                                <td>
                                    @if($today->status == 'confirmed')
                                        <span class="badge" style="background: #C8E6C9; color: #2E7D32;">Siap Main</span>
                                    @elseif($today->status == 'completed')
                                        <span class="badge" style="background: #E3F2FD; color: #1565C0;">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary text-white">{{ ucfirst($today->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('reservations.show', $today->id) }}" class="btn btn-sm btn-link font-weight-bold" style="color: var(--pastel-purple-dark);">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-coffee fa-2x mb-3 d-block"></i>
                                    Belum ada jadwal main untuk hari ini.
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