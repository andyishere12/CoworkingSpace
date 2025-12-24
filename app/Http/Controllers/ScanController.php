<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Reservasi;
use App\Models\DataMember;

class ScanController extends Controller
{
    public function index()
    {
        // ================= AMBIL MEMBER AKTIF HARI INI =================
        $activeMembers = DB::table('hadir')
            ->whereDate('tanggal', today())
            ->whereNull('waktu_keluar')
            ->join('data_members', 'hadir.member_id', '=', 'data_members.id')
            ->select('hadir.*', 'data_members.nama', 'data_members.type', 'data_members.foto')
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

        // ================= AMBIL UPCOMING EVENTS =================
        $upcomingEvents = Event::where('start_date', '>=', Carbon::today())
            ->where('status', 'active')
            ->orderBy('start_date', 'asc')
            ->take(3)
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

        // ================= AMBIL UPCOMING RESERVATIONS =================
        $upcomingReservations = Reservasi::where('tanggal', '>=', Carbon::today())
            ->where('status', '!=', 'Cancelled')
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->take(3)
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

        // ================= CARI MEMBER =================
        // Cari member berdasarkan ID atau NAMA (untuk manual check-in/out)
        if (isset($request->id)) {
            // Untuk QR scan & manual check-in dengan ID
            $member = DB::table('data_members')
                ->where('id', $request->id)
                ->first();
        } elseif (isset($request->nama)) {
            // Untuk manual check-out dengan nama
            $member = DB::table('data_members')
                ->where('nama', $request->nama)
                ->first();
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'ID atau Nama member tidak ditemukan'
            ], 404);
        }

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member tidak ditemukan'
            ], 404);
        }

        // Cek apakah member sudah check-in hari ini
        $hadir = DB::table('hadir')
            ->where('member_id', $member->id)
            ->whereDate('tanggal', $today)
            ->whereNull('waktu_keluar')
            ->first();

        // ================= CHECK OUT =================
        if ($hadir) {
            $waktuKeluar = Carbon::now();
            $durasi = Carbon::parse($hadir->waktu_masuk)->diffInSeconds($waktuKeluar);

            DB::table('hadir')
                ->where('id', $hadir->id)
                ->update([
                    'waktu_keluar' => $waktuKeluar->format('H:i:s'),
                    'durasi' => $durasi,
                    'updated_at' => now()
                ]);

            return response()->json([
                'status' => 'checkout',
                'nama' => $member->nama,
                'type' => $member->type ?? 'MEMBER',
                'foto' => $member->foto ? asset('uploads/foto/' . $member->foto) : asset('uploads/foto/default.png'),
                'timestamp' => now()->toIso8601String(),
                'should_remove' => true
            ]);
        }

        // ================= CHECK IN =================
        $waktuMasuk = Carbon::now()->format('H:i:s');

        DB::table('hadir')->insert([
            'member_id' => $member->id,
            'tanggal' => $today,
            'waktu_masuk' => $waktuMasuk,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'checkin',
            'nama' => $member->nama,
            'type' => $member->type ?? 'MEMBER',
            'foto' => $member->foto ? asset('uploads/foto/' . $member->foto) : asset('uploads/foto/default.png'),
            'timestamp' => now()->toIso8601String()
        ]);
    }

    // ================= ENDPOINT UNTUK MANUAL CHECK-OUT =================
    public function manualCheckout(Request $request)
    {
        $request->validate([
            'nama' => 'required|string'
        ]);

        $today = Carbon::today();

        // Cari member berdasarkan nama
        $member = DB::table('data_members')
            ->where('nama', $request->nama)
            ->first();

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member tidak ditemukan'
            ], 404);
        }

        // Cek apakah member sudah check-in hari ini
        $hadir = DB::table('hadir')
            ->where('member_id', $member->id)
            ->whereDate('tanggal', $today)
            ->whereNull('waktu_keluar')
            ->first();

        if (!$hadir) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member belum check-in hari ini'
            ], 400);
        }

        // Proses check-out
        $waktuKeluar = Carbon::now();
        $durasi = Carbon::parse($hadir->waktu_masuk)->diffInSeconds($waktuKeluar);

        DB::table('hadir')
            ->where('id', $hadir->id)
            ->update([
                'waktu_keluar' => $waktuKeluar->format('H:i:s'),
                'durasi' => $durasi,
                'updated_at' => now()
            ]);

        return response()->json([
            'status' => 'checkout',
            'nama' => $member->nama,
            'type' => $member->type ?? 'MEMBER',
            'foto' => $member->foto ? asset('uploads/foto/' . $member->foto) : asset('uploads/foto/default.png'),
            'timestamp' => now()->toIso8601String(),
            'should_remove' => true
        ]);
    }

    // ================= ENDPOINT UNTUK MANUAL CHECK-IN =================
    public function manualCheckin(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $today = Carbon::today();

        // Cari member berdasarkan ID
        $member = DB::table('data_members')
            ->where('id', $request->id)
            ->first();

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member tidak ditemukan'
            ], 404);
        }

        // Cek apakah sudah check-in hari ini
        $hadir = DB::table('hadir')
            ->where('member_id', $member->id)
            ->whereDate('tanggal', $today)
            ->whereNull('waktu_keluar')
            ->first();

        if ($hadir) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member sudah check-in hari ini'
            ], 400);
        }

        // Proses check-in
        $waktuMasuk = Carbon::now()->format('H:i:s');

        DB::table('hadir')->insert([
            'member_id' => $member->id,
            'tanggal' => $today,
            'waktu_masuk' => $waktuMasuk,
            'created_at' => now(), 
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'checkin',
            'nama' => $member->nama,
            'type' => $member->type ?? 'MEMBER',
            'foto' => $member->foto ? asset('uploads/foto/' . $member->foto) : asset('uploads/foto/default.png'),
            'timestamp' => now()->toIso8601String()
        ]);
    }

    // ================= ENDPOINT UNTUK REFRESH DATA =================
    public function getActiveMembers()
    {
        $activeMembers = DB::table('hadir')
            ->whereDate('tanggal', today())
            ->whereNull('waktu_keluar')
            ->join('data_members', 'hadir.member_id', '=', 'data_members.id')
            ->select('hadir.*', 'data_members.nama', 'data_members.type', 'data_members.foto')
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

        return response()->json($activeMembers);
    }

    // ================= ENDPOINT UNTUK PENCARIAN MEMBER =================
    // ================= ENDPOINT UNTUK PENCARIAN MEMBER =================
    public function searchMembers(Request $request)
    {
        $request->validate([
            'keyword' => 'nullable|string|max:100'
        ]);

        $query = DB::table('data_members')
            ->select('id', 'nama', 'email', 'type', 'institusi', 'foto');

        if ($request->filled('keyword')) {
            $keyword = '%' . $request->keyword . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', $keyword)
                    ->orWhere('email', 'like', $keyword)
                    ->orWhere('id', 'like', $keyword)
                    ->orWhere('no_hp', 'like', $keyword);
            });
        }

        // Hanya tampilkan maksimal 20 hasil
        $members = $query->orderBy('nama', 'asc')
            ->take(20)
            ->get()
            ->map(function ($member) {
                // Cek apakah sudah check-in hari ini
                $isActive = DB::table('hadir')
                    ->where('member_id', $member->id)
                    ->whereDate('tanggal', today())
                    ->whereNull('waktu_keluar')
                    ->exists();

                return [
                    'id' => $member->id,
                    'nama' => $member->nama,
                    'email' => $member->email,
                    'type' => $member->type ?? 'MEMBER',
                    'institusi' => $member->institusi ?? '-',
                    'foto_url' => $member->foto
                        ? asset('uploads/foto/' . $member->foto)
                        : asset('uploads/foto/default.png'),
                    'is_active' => $isActive
                ];
            });

        return response()->json($members);
    }
}