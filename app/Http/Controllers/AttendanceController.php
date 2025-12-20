<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hadir;
use App\Models\DataMember;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Hadir::with('member')
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_masuk', 'desc')
            ->paginate(20);
            
        $totalAttendance = Hadir::count();
        $todayAttendance = Hadir::whereDate('tanggal', today())->count();
        
        // Top members
        $topMembers = DB::table('hadir')
            ->select(
                'data_members.id',
                'data_members.nama',
                'data_members.foto',
                'data_members.type',
                DB::raw('COUNT(hadir.id) as total_visits')
            )
            ->join('data_members', 'hadir.nama', '=', 'data_members.nama')
            ->groupBy('data_members.id', 'data_members.nama', 'data_members.foto', 'data_members.type')
            ->orderByDesc('total_visits')
            ->limit(10)
            ->get();
        
        return view('attendance.index', compact(
            'attendances',
            'totalAttendance',
            'todayAttendance',
            'topMembers'
        ));
    }
    
    public function checkIn(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'type' => 'required|string'
        ]);
        
        // Cek apakah sudah check in hari ini
        $existing = Hadir::where('nama', $request->nama)
            ->whereDate('tanggal', today())
            ->first();
            
        if ($existing) {
            return back()->with('error', 'Anda sudah check in hari ini');
        }
        
        Hadir::create([
            'nama' => $request->nama,
            'type' => $request->type,
            'tanggal' => today(),
            'waktu_masuk' => now(),
        ]);
        
        return back()->with('success', 'Check in berhasil');
    }
    
    public function checkOut(Request $request)
    {
        $request->validate([
            'nama' => 'required|string'
        ]);
        
        $attendance = Hadir::where('nama', $request->nama)
            ->whereDate('tanggal', today())
            ->whereNull('waktu_keluar')
            ->first();
            
        if (!$attendance) {
            return back()->with('error', 'Tidak ada data check in untuk hari ini');
        }
        
        $checkIn = Carbon::parse($attendance->waktu_masuk);
        $checkOut = now();
        $duration = $checkIn->diffInMinutes($checkOut);
        
        $attendance->update([
            'waktu_keluar' => $checkOut,
            'durasi' => $duration
        ]);
        
        return back()->with('success', 'Check out berhasil');
    }
}