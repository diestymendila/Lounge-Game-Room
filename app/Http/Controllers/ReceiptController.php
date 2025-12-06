<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    /**
     * Show receipt page
     */
    public function show(Reservation $reservation)
    {
        // Check authorization
        if (Auth::user()->isCustomer() && $reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('receipts.show', compact('reservation'));
    }

    /**
     * Download receipt as PDF
     */
    public function download(Reservation $reservation)
    {
        // Check authorization
        if (Auth::user()->isCustomer() && $reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        try {
            $pdf = Pdf::loadView('receipts.pdf', compact('reservation'));
            
            return $pdf->download('receipt-' . $reservation->booking_code . '.pdf');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengunduh receipt: ' . $e->getMessage()]);
        }
    }

    /**
     * Print receipt
     */
    public function print(Reservation $reservation)
    {
        // Check authorization
        if (Auth::user()->isCustomer() && $reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('receipts.print', compact('reservation'));
    }
}