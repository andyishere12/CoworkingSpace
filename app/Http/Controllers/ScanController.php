<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Reservasi;

class ScanController extends Controller
{
    public function index()
    {
        $activeMembers = DB::table('hadir')
            ->whereDate('tanggal', today())
            ->whereNull('waktu_keluar')
            ->join('data_members', 'hadir.nama', '=', 'data_members.nama')
            ->select('hadir.*', 'data_members.foto')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->nama,
                    'type' => $item->type ?? 'MEMBER',
                    'foto_url' => $item->foto
                        ? asset('uploads/foto/' . $item->foto)
                        : asset('uploads/foto/default.png'),
                    'timestamp' => Carbon::parse($item->created_at)->toIso8601String(),
                ];
            });

        // Ambil upcoming events (start_date >= hari ini, status active)
        $upcomingEvents = Event::where('start_date', '>=', Carbon::today())
            ->where('status', 'active')
            ->orderBy('start_date', 'asc')
            ->take(3) // Batasi 3 event terdekat
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'status' => $event->status,
                    'formatted_date' => Carbon::parse($event->start_date)->format('d M Y'),
                    'days_until' => Carbon::parse($event->start_date)->diffForHumans(),
                ];
            });

        // Ambil upcoming reservations (tanggal >= hari ini, bukan status 'Cancelled')
        $upcomingReservations = Reservasi::where('tanggal', '>=', Carbon::today())
            ->where('status', '!=', 'Cancelled')
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->take(3) // Batasi 3 reservation terdekat
            ->get()
            ->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'nama_pemesanan' => $reservation->nama_pemesanan,
                    'purpose' => $reservation->purpose,
                    'tanggal' => $reservation->tanggal,
                    'waktu_mulai' => $reservation->waktu_mulai,
                    'waktu_selesai' => $reservation->waktu_selesai,
                    'ruangan' => $reservation->ruangan,
                    'status' => $reservation->status,
                    'formatted_date' => Carbon::parse($reservation->tanggal)->format('d M Y'),
                    'formatted_time' => date('H:i', strtotime($reservation->waktu_mulai)) . ' - ' . date('H:i', strtotime($reservation->waktu_selesai)),
                ];
            });

        return view('scan.scanner', compact('activeMembers', 'upcomingEvents', 'upcomingReservations'));
    }

    public function store(Request $request)
    {
        $today = Carbon::today();

        $member = DB::table('data_members')
            ->where('nama', $request->nama)
            ->first();

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member tidak ditemukan'
            ], 404);
        }

        // ambil hadir aktif hari ini
        $hadir = DB::table('hadir')
            ->where('nama', $request->nama)
            ->whereDate('tanggal', $today)
            ->whereNull('waktu_keluar')
            ->first();

        // ================= CHECK OUT =================
        if ($hadir) {
            $waktuKeluar = Carbon::now();
            $durasi = Carbon::parse($hadir->waktu_masuk)
                ->diffInSeconds($waktuKeluar);

            DB::table('hadir')
                ->where('id', $hadir->id)
                ->update([
                    'waktu_keluar' => $waktuKeluar->format('H:i:s'),
                    'durasi' => $durasi,
                    'updated_at' => now()
                ]);

            return response()->json([
                'status' => 'checkout',
                'nama' => $request->nama
            ]);
        }

        // ================= CHECK IN =================
        $waktuMasuk = Carbon::now()->format('H:i:s');

        DB::table('hadir')->insert([
            'nama' => $request->nama,
            'type' => $request->type ?? 'MEMBER',
            'tanggal' => $today,
            'waktu_masuk' => $waktuMasuk,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'checkin',
            'nama' => $request->nama,
            'foto' => $member->foto
                ? asset('uploads/foto/' . $member->foto)
                : asset('uploads/foto/default.png'),
            'timestamp' => now()->toIso8601String()
        ]);
    }
}