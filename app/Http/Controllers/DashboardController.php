<?php

namespace App\Http\Controllers;

use App\Models\GameRoom;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isCustomer()) {
            return $this->customerDashboard();
        } elseif ($user->isReceptionist()) {
            return $this->receptionistDashboard();
        } elseif ($user->isManager()) { // Asumsi fungsi isManager() atau isAdmin() ada di model User
            return $this->managerDashboard();
        }

        // Default redirect jika role tidak dikenali
        return redirect()->route('login');
    }

    /**
     * Customer Dashboard
     */
    private function customerDashboard()
    {
        $gameRooms = GameRoom::where('status', 'available')->get();
        $myReservations = Reservation::where('user_id', Auth::id())
            ->with('gameRoom')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.customer', compact('gameRooms', 'myReservations'));
    }

    /**
     * Receptionist Dashboard
     */
    private function receptionistDashboard()
    {
        $pendingReservations = Reservation::where('status', 'pending')
            ->with(['user', 'gameRoom'])
            ->orderBy('created_at', 'desc')
            ->get();

        $todayReservations = Reservation::whereDate('reservation_date', today())
            ->with(['user', 'gameRoom'])
            ->orderBy('start_time')
            ->get();

        return view('dashboard.receptionist', compact('pendingReservations', 'todayReservations'));
    }

    /**
     * Manager/Admin Dashboard
     */
    private function managerDashboard()
    {
        // 1. Statistik Kartu Atas
        $totalRooms = GameRoom::count();
        $totalReservations = Reservation::count();
        
        // Hitung pendapatan (hanya dari status yang valid)
        $totalRevenue = Reservation::whereIn('status', ['confirmed', 'completed', 'paid'])->sum('total_price');
        
        // Hitung user dengan role customer
        $totalCustomers = User::where('role', 'customer')->count();

        // 2. Reservasi Terbaru (Untuk tabel history opsional)
        $recentReservations = Reservation::with(['user', 'gameRoom'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // 3. Data Ruangan untuk Tabel Statistik
        // PENTING: Kita namakan variablenya $rooms (bukan $gameRooms)
        // Agar sesuai dengan @foreach($rooms as $room) di view manager.blade.php
        $rooms = GameRoom::withCount('reservations')->get();

        return view('dashboard.manager', compact(
            'totalRooms',
            'totalReservations',
            'totalRevenue',
            'totalCustomers',
            'recentReservations',
            'rooms' // <--- Ini perbaikan kuncinya
        ));
    }
}