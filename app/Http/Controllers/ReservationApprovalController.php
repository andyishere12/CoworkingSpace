<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;

class ReservationApprovalController extends Controller
{
    /**
     * Tampilkan halaman reservation approval
     */
    public function index()
    {
        try {
            $pendingReservasi = Reservasi::where('status', 'Pending')
                ->orderBy('tanggal', 'asc')
                ->get();

            $approvedReservasi = Reservasi::where('status', 'Approved')
                ->orderBy('updated_at', 'desc')
                ->get();

            $rejectedReservasi = Reservasi::where('status', 'Rejected')
                ->orderBy('updated_at', 'desc')
                ->get();

            $stats = [
                'total_pending'  => Reservasi::where('status', 'Pending')->count(),
                'total_approved' => Reservasi::where('status', 'Approved')->count(),
                'total_rejected' => Reservasi::where('status', 'Rejected')->count(),
                'total_all'      => Reservasi::count(),
            ];

            return view('manager.reservation-approval', compact(
                'pendingReservasi',
                'approvedReservasi',
                'rejectedReservasi',
                'stats'
            ));

        } catch (\Exception $e) {
            \Log::error('Reservation Approval Error: ' . $e->getMessage());

            return view('manager.reservation-approval', [
                'pendingReservasi'  => collect(),
                'approvedReservasi' => collect(),
                'rejectedReservasi' => collect(),
                'stats' => [
                    'total_pending'  => 0,
                    'total_approved' => 0,
                    'total_rejected' => 0,
                    'total_all'      => 0,
                ],
            ]);
        }
    }

    /**
     * Approve reservasi
     */
    public function approve($id)
    {
        try {
            $reservasi = Reservasi::findOrFail($id);

            if ($reservasi->status !== 'Pending') {
                return redirect()->back()->with('error', 'Reservasi sudah diproses sebelumnya!');
            }

            $reservasi->status = 'Approved';
            $reservasi->save();

            return redirect()->route('manager.reservation-approval.index')
                ->with('success', "Reservasi \"{$reservasi->nama_pemesanan}\" berhasil disetujui!");

        } catch (\Exception $e) {
            \Log::error('Approve Reservation Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyetujui reservasi: ' . $e->getMessage());
        }
    }

    /**
     * Reject reservasi
     */
    public function reject(Request $request, $id)
    {
        try {
            $reservasi = Reservasi::findOrFail($id);

            if ($reservasi->status !== 'Pending') {
                return redirect()->back()->with('error', 'Reservasi sudah diproses sebelumnya!');
            }

            $reservasi->status = 'Rejected';
            $reservasi->save();

            return redirect()->route('manager.reservation-approval.index')
                ->with('success', "Reservasi \"{$reservasi->nama_pemesanan}\" berhasil ditolak!");

        } catch (\Exception $e) {
            \Log::error('Reject Reservation Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menolak reservasi: ' . $e->getMessage());
        }
    }
}
