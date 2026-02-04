<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;

class ReservationApprovalController extends Controller
{
    /**
     * Display reservations pending approval
     */
    public function index()
    {
        $reservations = Reservasi::with('member')
            ->whereIn('status', ['pending', 'approved', 'rejected'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->get();

        return view('manager.reservation-approval', compact('reservations'));
    }

    /**
     * Approve a reservation
     */
    public function approve($id)
    {
        $reservation = Reservasi::findOrFail($id);
        $reservation->status = 'approved';
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation has been approved successfully.');
    }

    /**
     * Reject a reservation
     */
    public function reject($id)
    {
        $reservation = Reservasi::findOrFail($id);
        $reservation->status = 'rejected';
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation has been rejected.');
    }
}
