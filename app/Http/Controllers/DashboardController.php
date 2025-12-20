<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Hadir;
use App\Models\DataMember;
use App\Models\Reservasi;
use App\Models\Room;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        // Data statistik
        $totalMembers = DataMember::count();
        
        // Reservasi bulan ini
        $totalReservations = Reservasi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        
        // Hitung total rooms
        $totalRooms = Room::count();
        
        // Events yang akan datang (status active)
        $totalEvents = Event::where('status', 'active')
            ->whereDate('start_date', '>=', now())
            ->count();
        
        // Debug: Cek data hadir
        $debugHadir = DB::table('hadir')->get();
        
        // Debug: Cek data members
        $debugMembers = DB::table('data_members')->get();
        
        // Top 10 members yang paling sering berkunjung (dengan foto dari database)
        $topMembers = DB::table('hadir')
            ->select(
                'data_members.id',
                'data_members.nama',
                'data_members.foto',
                'data_members.type',
                DB::raw('COUNT(hadir.id) as total_visits'),
                DB::raw('MAX(hadir.tanggal) as last_visit')
            )
            ->join('data_members', 'hadir.nama', '=', 'data_members.nama')
            ->groupBy('data_members.id', 'data_members.nama', 'data_members.foto', 'data_members.type')
            ->orderByDesc('total_visits')
            ->orderBy('data_members.nama', 'asc') // Untuk konsistensi jika total_visits sama
            ->limit(10)
            ->get();

        // Data kehadiran hari ini
        $todayAttendance = DB::table('hadir')
            ->whereDate('tanggal', today())
            ->count();

        return view('dashboard.index', compact(
            'totalMembers',
            'totalReservations',
            'totalRooms',
            'totalEvents',
            'topMembers',
            'todayAttendance'
        ));
    }
}