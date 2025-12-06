<?php

namespace App\Http\Controllers;

use App\Models\GameRoom;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of reservations
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isCustomer()) {
            $reservations = Reservation::where('user_id', $user->id)
                ->with('gameRoom')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $reservations = Reservation::with(['user', 'gameRoom'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new reservation
     */
    public function create(Request $request)
    {
        $gameRoomId = $request->get('game_room_id');
        $gameRoom = null;

        if ($gameRoomId) {
            $gameRoom = GameRoom::findOrFail($gameRoomId);
        }

        $gameRooms = GameRoom::where('status', 'available')->get();
        
        return view('reservations.create', compact('gameRooms', 'gameRoom'));
    }

    /**
     * Store a newly created reservation
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_room_id' => 'required|exists:game_rooms,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'duration_hours' => 'required|integer|min:1|max:12',
            'notes' => 'nullable|string',
        ], [
            'game_room_id.required' => 'Pilih ruangan game',
            'reservation_date.required' => 'Tanggal reservasi wajib diisi',
            'reservation_date.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini',
            'start_time.required' => 'Waktu mulai wajib diisi',
            'duration_hours.required' => 'Durasi wajib diisi',
            'duration_hours.min' => 'Durasi minimal 1 jam',
            'duration_hours.max' => 'Durasi maksimal 12 jam',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $gameRoom = GameRoom::findOrFail($request->game_room_id);

            // Calculate end time
            $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
            $durationHours = (int) $request->duration_hours; // Convert to integer
            $endTime = $startTime->copy()->addHours($durationHours);

            // Calculate total price
            $totalPrice = $gameRoom->price_per_hour * $durationHours;

            // Create reservation
            $reservation = Reservation::create([
                'booking_code' => Reservation::generateBookingCode(),
                'user_id' => Auth::id(),
                'game_room_id' => $request->game_room_id,
                'reservation_date' => $request->reservation_date,
                'start_time' => $request->start_time,
                'end_time' => $endTime->format('H:i:s'),
                'duration_hours' => $durationHours,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            // Send WhatsApp notification
            $this->sendWhatsAppNotification($reservation);

            return redirect()->route('reservations.show', $reservation->id)
                ->with('success', 'Reservasi berhasil dibuat! Silakan tunggu konfirmasi dari resepsionis.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified reservation
     */
    public function show(Reservation $reservation)
    {
        // Check authorization
        if (Auth::user()->isCustomer() && $reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Update reservation status
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:confirmed,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $reservation->update(['status' => $request->status]);

            // Send notification for status change
            if ($request->status === 'confirmed') {
                $this->sendConfirmationNotification($reservation);
            }

            return back()->with('success', 'Status reservasi berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing reservation
     */
    public function edit(Reservation $reservation)
    {
        // Check authorization
        if (Auth::user()->isCustomer() && $reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Only allow edit for pending and confirmed status
        if (!in_array($reservation->status, ['pending', 'confirmed'])) {
            return redirect()->route('reservations.show', $reservation->id)
                ->withErrors(['error' => 'Hanya reservasi dengan status Pending atau Confirmed yang bisa diedit']);
        }

        $gameRooms = GameRoom::where('status', 'available')->get();
        
        return view('reservations.edit', compact('reservation', 'gameRooms'));
    }

    /**
     * Update the specified reservation
     */
    public function update(Request $request, Reservation $reservation)
    {
        // Check authorization
        if (Auth::user()->isCustomer() && $reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $validator = Validator::make($request->all(), [
            'game_room_id' => 'required|exists:game_rooms,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'duration_hours' => 'required|integer|min:1|max:12',
            'notes' => 'nullable|string',
        ], [
            'game_room_id.required' => 'Pilih ruangan game',
            'reservation_date.required' => 'Tanggal reservasi wajib diisi',
            'reservation_date.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini',
            'start_time.required' => 'Waktu mulai wajib diisi',
            'duration_hours.required' => 'Durasi wajib diisi',
            'duration_hours.min' => 'Durasi minimal 1 jam',
            'duration_hours.max' => 'Durasi maksimal 12 jam',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $gameRoom = GameRoom::findOrFail($request->game_room_id);

            // Calculate end time
            $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
            $durationHours = (int) $request->duration_hours;
            $endTime = $startTime->copy()->addHours($durationHours);

            // Calculate total price
            $totalPrice = $gameRoom->price_per_hour * $durationHours;

            // Update reservation
            $reservation->update([
                'game_room_id' => $request->game_room_id,
                'reservation_date' => $request->reservation_date,
                'start_time' => $request->start_time,
                'end_time' => $endTime->format('H:i:s'),
                'duration_hours' => $durationHours,
                'total_price' => $totalPrice,
                'notes' => $request->notes,
            ]);

            return redirect()->route('reservations.show', $reservation->id)
                ->with('success', 'Reservasi berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified reservation
     */
    public function destroy(Reservation $reservation)
    {
        // Check authorization
        if (Auth::user()->isCustomer() && $reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        try {
            // Only allow delete for pending and cancelled status
            if (!in_array($reservation->status, ['pending', 'cancelled'])) {
                return back()->withErrors(['error' => 'Hanya reservasi dengan status Pending atau Cancelled yang bisa dihapus']);
            }

            $reservation->delete();

            return redirect()->route('reservations.index')
                ->with('success', 'Reservasi berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Cancel reservation
     */
    public function cancel(Reservation $reservation)
    {
        try {
            if ($reservation->status === 'completed') {
                return back()->withErrors(['error' => 'Tidak dapat membatalkan reservasi yang sudah selesai']);
            }

            $reservation->update(['status' => 'cancelled']);

            return back()->with('success', 'Reservasi berhasil dibatalkan!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Send WhatsApp notification when reservation created
     */
    private function sendWhatsAppNotification($reservation)
    {
        try {
            $user = $reservation->user;
            $gameRoom = $reservation->gameRoom;
            
            $message = "🎮 *RESERVASI LOUNGE GAME ROOM*\n\n";
            $message .= "Halo *{$user->name}*,\n\n";
            $message .= "Reservasi Anda telah berhasil dibuat!\n\n";
            $message .= "📋 *Detail Reservasi:*\n";
            $message .= "Kode Booking: *{$reservation->booking_code}*\n";
            $message .= "Ruangan: *{$gameRoom->name}*\n";
            $message .= "Tanggal: *{$reservation->reservation_date}*\n";
            $message .= "Waktu: *{$reservation->start_time}* - *{$reservation->end_time}*\n";
            $message .= "Durasi: *{$reservation->duration_hours} jam*\n";
            $message .= "Total Harga: *{$reservation->formatted_total_price}*\n";
            $message .= "Status: *{$reservation->status_label}*\n\n";
            $message .= "Terima kasih telah memesan! 🙏";

            // Format phone number (remove leading 0, add 62)
            $phone = $user->phone;
            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            }

            // Send via WhatsApp API (using simple URL method)
            $apiUrl = env('WHATSAPP_API_URL');
            $token = env('WHATSAPP_TOKEN');

            if ($apiUrl && $token) {
                Http::post($apiUrl, [
                    'target' => $phone,
                    'message' => $message,
                    'token' => $token,
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }
    }

    /**
     * Send confirmation notification
     */
    private function sendConfirmationNotification($reservation)
    {
        try {
            $user = $reservation->user;
            $gameRoom = $reservation->gameRoom;
            
            $message = "✅ *RESERVASI DIKONFIRMASI*\n\n";
            $message .= "Halo *{$user->name}*,\n\n";
            $message .= "Reservasi Anda telah dikonfirmasi!\n\n";
            $message .= "Kode Booking: *{$reservation->booking_code}*\n";
            $message .= "Ruangan: *{$gameRoom->name}*\n";
            $message .= "Tanggal: *{$reservation->reservation_date}*\n";
            $message .= "Waktu: *{$reservation->start_time}* - *{$reservation->end_time}*\n\n";
            $message .= "Sampai jumpa! 🎮";

            $phone = $user->phone;
            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            }

            $apiUrl = env('WHATSAPP_API_URL');
            $token = env('WHATSAPP_TOKEN');

            if ($apiUrl && $token) {
                Http::post($apiUrl, [
                    'target' => $phone,
                    'message' => $message,
                    'token' => $token,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('WhatsApp confirmation failed: ' . $e->getMessage());
        }
    }
}