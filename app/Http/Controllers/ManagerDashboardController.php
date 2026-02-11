<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMember;
use App\Models\Event;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        // Total Members
        $totalMembers = DataMember::count();

        // Pending Reservations (status = 'Pending')
        $pendingReservations = Reservasi::where('status', 'Pending')->count();

        // Pending Events (status = 'pending')
        $pendingEvents = Event::where('status', 'pending')->count();

        // Active Today - FIX: Pakai table hadir dengan kolom yang benar
        $activeToday = DB::table('hadir')
            ->whereDate('tanggal', Carbon::today())
            ->whereNotNull('waktu_masuk')
            ->whereNull('waktu_keluar')
            ->count();

        return view('manager.dashboard', compact(
            'totalMembers',
            'pendingReservations',
            'pendingEvents',
            'activeToday'
        ));
    }
}